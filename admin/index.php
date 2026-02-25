<?php
session_start();
include '../partials/_dbconnect.php';
if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin']) {
    $admin = $_SESSION['admin_name'];
    $sql = "SELECT COUNT(*) AS total_orders, 
    SUM(IF(order_status != 'cancelled', total_amount, 0)) AS total_revenue FROM `orders`;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $total_orders = $row['total_orders'];
        $total_revenue = $row['total_revenue'] ? $row['total_revenue'] : 0;
    }

    $sql_prod = "SELECT COUNT(*) as total_products FROM `products`";
    $res_prod = mysqli_query($conn, $sql_prod);
    if (mysqli_num_rows($res_prod) > 0) {
        $row_prod = mysqli_fetch_assoc($res_prod);
        $total_products = $row_prod['total_products'];
    }

    $sql_users = "SELECT COUNT(*) AS total_users FROM `userbase`";
    $res_user = mysqli_query($conn, $sql_users);
    if (mysqli_num_rows($res_user) > 0) {
        $row_user = mysqli_fetch_assoc($res_user);
        $total_users = $row_user['total_users'];
    }
} else {
    header('location: login.php');
    exit;
}
include 'components/_sidebar.php';
?>


<!-- index page main content -->
<div class="container-fluid px-4">

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex justify-content-between align-items-center p-3">
                    <div>
                        <p class="text-muted small fw-bold mb-1">TOTAL ORDERS</p>
                        <h3 class="fw-bold mb-0 text-dark"><?php echo $total_orders ?></h3>
                    </div>
                    <div class="text-primary bg-primary bg-opacity-10 px-3 py-2 rounded-3">
                        <i class="bi bi-bag-check-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex justify-content-between align-items-center p-3">
                    <div>
                        <p class="text-muted small fw-bold mb-1">TOTAL REVENUE</p>
                        <h3 class="fw-bold mb-0 text-dark">₹<?php echo $total_revenue ?></h3>
                    </div>
                    <div class="text-success bg-success bg-opacity-10 px-3 py-2 rounded-3">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex justify-content-between align-items-center p-3">
                    <div>
                        <p class="text-muted small fw-bold mb-1">TOTAL PRODUCTS</p>
                        <h3 class="fw-bold mb-0 text-dark"><?php echo $total_products ?></h3>
                    </div>
                    <div class="text-warning bg-warning bg-opacity-10 px-3 py-2 rounded-3">
                        <i class="bi bi-box-seam-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex justify-content-between align-items-center p-3">
                    <div>
                        <p class="text-muted small fw-bold mb-1">TOTAL USERS</p>
                        <h3 class="fw-bold mb-0 text-dark"><?php echo $total_users ?></h3>
                    </div>
                    <div class="text-info bg-info bg-opacity-10 px-3 py-2 rounded-3">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold m-0 text-dark">Recent Orders</h5>
            <a href="orders.php" class="btn btn-outline-success btn-sm fw-bold">View All</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">


                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_table = "SELECT orders.*, user_address.name FROM `orders` JOIN user_address ON 
                            orders.address_id = user_address.id ORDER BY orders.dt DESC LIMIT 5;";
                    $res_table = mysqli_query($conn, $sql_table);
                    if (mysqli_num_rows($res_table) > 0) {
                        while ($rowTable = mysqli_fetch_assoc($res_table)) {
                            $ref_id = $rowTable['order_ref_id'];
                            $customer = $rowTable['name'];
                            $date = date("M d, Y ", strtotime($rowTable['dt']));
                            $amount = $rowTable['total_amount'];
                            $status = $rowTable['order_status'];
                            $order_id = $rowTable['order_id'];
                            $bg = 'success';
                            $text = 'text-white';
                            if ($status == 'Placed') {
                                $bg = 'warning';
                                $text = 'text-dark';
                            } elseif ($status == 'Shipped') {
                                $bg = 'primary';
                            } elseif ($status == 'Cancelled') {
                                $bg = 'danger';
                            }

                            echo '
                                    <tr>
                                        <td class="fw-bold text-secondary">#' . $ref_id . '</td>
                                        <td>' . $customer . '</td>
                                        <td>' . $date . '</td>
                                        <td class="fw-bold text-success">₹' . $amount . '</td>
                                        <td><span class="badge bg-' . $bg . ' ' . $text . ' px-2 py-1">' . $status . '</span></td>
                                        <td>
                                            <button class="btn view-btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewOrderModal" 
                                            data-order-id="' . $order_id . '">view</button>
                                        </td>
                                    </tr>  
                                    ';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="viewOrderModalLabel">Order Details / Invoice</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="orderDetailsContent">
                <!-- js content here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="printInvoiceBtn" target="_blank" class="btn btn-success">Print Invoice</a>
            </div>
        </div>
    </div>
</div>
<script src="javascripts/index.js"></script>
<?php include 'components/_footer.php' ?>