<?php 
session_start();
include '_dbconnect.php';
if(!isset($_SESSION['user_id'])){
    header('location: index.php');
    exit;
}
if(isset($_GET['id'])){
    $order_id = $_GET['id'];
    $uid = $_SESSION['user_id'];

    $sql = "SELECT * FROM `orders` WHERE `order_id` = '$order_id' AND `user_id` = '$uid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $ref_id = $row['order_ref_id'];
    $date = date("d M Y", strtotime($row['dt']));
    $status = $row['order_status'];
    $address_id = $row['address_id'];
    $payment = $row['payment_method'];
    if(!$row){
        echo '<div style="text-align:center; padding:50px;"><h3>Order not found or access denied!</h3></div>';
        exit;
    }
}else{
    echo "Invalid Request!";
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice <?php echo $ref_id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            background-color: #f3f4f6;
            padding: 30px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .invoice-container {
            background: #fff;
            max-width: 850px;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            position: relative;
        }
        .invoice-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-logo {
            font-size: 28px;
            font-weight: 800;
            color: #198754; 
            letter-spacing: 1px;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-align: right;
        }
        .invoice-meta {
            text-align: right;
            font-size: 14px;
            color: #666;
        }
        .client-info h6, .company-info h6 {
            font-weight: 700;
            color: #444;
            text-transform: uppercase;
            font-size: 0.85rem;
            margin-bottom: 10px;
        }
        .table-invoice th {
            background-color: #f8f9fa;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            color: #555;
            border-bottom: 2px solid #e9ecef;
        }
        .table-invoice td {
            vertical-align: middle;
            font-size: 0.95rem;
            padding: 12px 10px;
        }
        .total-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
        }
        .grand-total {
            font-size: 1.2rem;
            font-weight: bold;
            color: #198754;
        }
        .footer-note {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #888;
            font-size: 0.85rem;
            text-align: center;
        }
        /* hide button during print */
        @media print {
            body { background: #fff; padding: 0; }
            .invoice-container { box-shadow: none; border: none; padding: 20px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="container text-center mb-4 no-print">
        <button onclick="downloadPDF()" class="btn btn-primary px-4 shadow-sm">
            <i class="bi bi-printer-fill me-2"></i> Print Invoice
        </button>
        <button onclick="window.close()" class="btn btn-outline-secondary px-4 ms-2">
           <i class="bi bi-x-lg me-2"></i> Close Window
        </button>
    </div>

    <div class="invoice-container">
        
        <div class="invoice-header d-flex justify-content-between align-items-center">
            <div>
                <div class="company-logo"><i class="bi bi-cart4"></i>PureGrocery</div>
                <p class="mb-0 text-muted small">123, Market Street, Kolkata - 700001</p>
                <p class="mb-0 text-muted small">Email: support@grocery.com | Phone: +91 98765 43210</p>
            </div>
            <div>
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-meta">
                    <p class="mb-1"><strong>Invoice No:</strong> <?php echo $ref_id ?></p>
                    <p class="mb-1"><strong>Date:</strong> <?php echo $date ?></p>
                    <p class="mb-0"><strong>Status:</strong> <span class="badge bg-success bg-opacity-10 text-success"><?php echo $status ?></span></p>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-6 client-info">
                <h6>Bill To:</h6>
                <?php 
                $query = "SELECT * FROM    `user_address` WHERE `user_id` = $uid AND `id` = $address_id";
                $res = mysqli_query($conn, $query);
                $info = mysqli_fetch_assoc($res);
                if($info){
                    echo '
                    <p class="fw-bold mb-1 text-dark">'.$info['name'].'</p>
                    <p class="mb-1 text-muted">'.$info['address_line1'].'</p>
                    <p class="mb-1 text-muted">'.$info['state'].', India - '.$info['pincode'].'</p>
                    <p class="mb-0 text-muted">Phone: '.$info['phone'].'</p>
                    ';

                }
                ?>
            </div>
            <div class="col-6 text-end client-info">
                <h6>Order Details:</h6>
                <p class="mb-1"><strong>Order ID:</strong> <?php echo $ref_id ?></p>
                <p class="mb-1"><strong>Payment Method:</strong> <?php echo $payment ?></p>
            </div>
        </div>
        <!-- details in table -->
        <div class="table-responsive mb-4">
            <table class="table table-invoice">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 50%;">Item Description</th>
                        <th class="text-center" style="width: 15%;">Qty</th>
                        <th class="text-end" style="width: 15%;">Unit Price</th>
                        <th class="text-end" style="width: 15%;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql_items = "SELECT order_items.*, products.*, categories.category_name 
                                    FROM `order_items` JOIN `products` ON order_items.product_id = products.id 
                                    JOIN `categories` ON products.category_id = categories.id 
                                    WHERE order_items.order_id = '$order_id'";
                    $res_items = mysqli_query($conn, $sql_items);
                    $count = 1;
                    $grand_total = 0;
                    if(mysqli_num_rows($res_items) > 0){
                        while($item = mysqli_fetch_assoc($res_items)){
                            $name =strtoupper($item['product_name']);
                            $price = $item['price'];
                            $qty = $item['qty'];
                            $subtotal = $price * $qty;
                            $grand_total += $subtotal;
                            $unit = 'kg';
                            $category = $item['category_name'];
                            if($item['category_id'] == 4){
                                $unit = 'Liter';
                            }
                            echo '
                            <tr>
                                <td>'.$count.'</td>
                                <td>
                                    <span class="fw-bold d-block text-dark">'.$name.'</span>
                                    <span class="small text-muted">Category: '.$category.'</span>
                                </td>
                                <td class="text-center">'.$qty.' '.$unit.'</td>
                                <td class="text-end">₹'.$price.'</td>
                                <td class="text-end fw-bold">₹'.$subtotal.'</td>
                            </tr>
                            ';
                            $count++; 
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- small subtotal and total div in right corner -->
        <div class="row justify-content-end">
            <div class="col-md-5">
                <div class="total-section">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Sub Total</span>
                        <span class="fw-bold">₹<?php echo $grand_total ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping Charge</span>
                        <span class="fw-bold text-dark">+ ₹0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span class="text-muted">Discount</span>
                        <span class="fw-bold text-danger">- ₹0.00</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark fs-5">Grand Total</span>
                        <span class="grand-total">₹<?php echo $grand_total ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-note">
            <p class="mb-1 fw-bold">Thank you for shopping with us!</p>
            <p class="mb-0">For any queries, please contact support within 24 hours.</p>
        </div>

    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function downloadPDF() {
        const element = document.querySelector('.invoice-container'); 
        
        // configaretion 
        const opt = {
            margin: 5,
            filename: 'Invoice_<?php echo $ref_id; ?>.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        // download
        html2pdf().set(opt).from(element).save();
    }
</script>
</body>
</html>