<?php
session_start();
include '../../partials/_dbconnect.php';

if(!isset($_SESSION['admin_loggedin']) || !$_SESSION['admin_loggedin']){
    exit;
}

if(isset($_POST['order_id'])){
    
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $info_sql = "SELECT o.order_ref_id, o.payment_method, ua.* FROM orders o 
                 JOIN user_address ua ON o.address_id = ua.id 
                 WHERE o.order_id = '$order_id'";
                 
    $info_result = mysqli_query($conn, $info_sql);
    
    if($info_row = mysqli_fetch_assoc($info_result)) {
        $c_name = $info_row['name'];
        $c_phone = $info_row['phone'];
        $order_ref = $info_row['order_ref_id'];
        $order_method = $info_row['payment_method'];
        
        $c_address = isset($info_row['address_line1']) ? $info_row['address_line1'] : 'Address not found'; 
        

        echo '
        <div class="card mb-4 border-0 shadow-sm" style="background-color: #f8f9fa;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                    <h6 class="text-success m-0"><i class="fas fa-user-circle me-1"></i> Customer Info</h6>
                    <span class="badge bg-secondary">Order #'.$order_ref.'</span>
                </div>
                <div class="row">
                    <div class="col-sm-6 mb-2 mb-sm-0">
                        <small class="text-muted d-block">Name & Contact:</small>
                        <strong class="text-dark">'.$c_name.'</strong><br>
                        <small>'.$c_phone.'</small>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Delivery Address:</small>
                        <small class="text-dark">'.$c_address.'</small><br>
                        <small class="badge bg-secondary">'.$order_method.'</small>
                    </div>
                </div>
            </div>
        </div>
        <h6 class="text-secondary mb-3"><i class="fas fa-shopping-bag me-1"></i> Order Items</h6>
        ';
    }

   
    $sql = "SELECT oi.qty, oi.price, p.product_name, p.image 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id = '$order_id'";
            
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        echo '<ul class="list-group mb-3">';
        $grand_total = 0;

        while($row = mysqli_fetch_assoc($result)){
            $product_name = $row['product_name'];
            $qty = $row['qty'];
            $price = $row['price'];
            $image = $row['image']; 
            
            $item_total = $price * $qty; 
            $grand_total += $item_total;

            
            $image_path = '../partials/images/productImages/' . $image; 

            echo '
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="'.$image_path.'" alt="'.$product_name.'" style="width: 45px; height: 45px; object-fit: cover; border-radius: 8px; margin-right: 15px; border: 1px solid #ddd;">
                    <div>
                        <h6 class="my-0 text-dark">'.$product_name.'</h6>
                        <small class="text-muted">Qty: '.$qty.' x ₹'.$price.'</small>
                    </div>
                </div>
                <span class="text-dark fw-bold">₹ '.$item_total.'</span>
            </li>';
        }
        
        // total bill row
        echo '
            <li class="list-group-item d-flex justify-content-between bg-light mt-2 border-success border-2">
                <span class="text-success fw-bold">Grand Total</span>
                <strong class="text-success fs-5">₹ '.$grand_total.'</strong>
            </li>
        </ul>';
    } else {
        echo '<div class="text-center py-4">
                <i class="fas fa-box-open text-muted fs-1 mb-3"></i>
                <p class="text-danger">No items found for this order!</p>
              </div>';
    }
}
?>