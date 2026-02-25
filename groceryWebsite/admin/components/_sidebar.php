<?php
if (!isset($_SESSION['admin_loggedin']) || !$_SESSION['admin_loggedin']) {
    header('location: login.php');
    exit;
}
$admin = $_SESSION['admin_name'];

?>
<!DOCTYPE html>
<html lang="en">
<?php $current_page = basename($_SERVER['PHP_SELF']) ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PureGrocery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

    <div class="d-md-none bg-success text-white p-3 d-flex justify-content-between align-items-center shadow-sm">
        <h4 class="fw-bold mb-0"><i class="bi bi-cart4 me-2"></i>PureGrocery</h4>
        <button class="btn btn-light text-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <div class="d-flex vh-100">

        <div class="offcanvas-md offcanvas-start bg-success text-white flex-column flex-shrink-0 p-3 shadow" 
             tabindex="-1" id="sidebarMenu" style="width: 250px; min-width: 250px;">
            
            <div class="offcanvas-header d-md-none border-bottom border-light border-opacity-25 mb-3">
                <h5 class="offcanvas-title fw-bold"><i class="bi bi-cart4 me-2"></i>PureGrocery</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"></button>
            </div>

            <div class="text-center py-2 border-bottom border-light border-opacity-25 mb-3 d-none d-md-block">
                <h4 class="fw-bold mb-0"><i class="bi bi-cart4 me-2"></i>PureGrocery</h4>
                <small class="text-white-50">Admin Panel</small>
            </div>

            <ul class="nav nav-pills flex-column mb-auto gap-1 overflow-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link <?php echo ($current_page == 'index.php' || $current_page == '') ? 'active bg-white text-success fw-bold' : 'text-white' ?>">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="orders.php" class="nav-link <?php echo $current_page == 'orders.php' ? 'active bg-white text-success fw-bold' : 'text-white' ?>">
                        <i class="bi bi-bag-check me-2"></i> Orders
                    </a>
                </li>
                <li>
                    <a href="products.php" class="nav-link <?php echo $current_page == 'products.php' ? 'active bg-white text-success fw-bold' : 'text-white' ?>">
                        <i class="bi bi-box-seam me-2"></i> Products
                    </a>
                </li>
                <li>
                    <a href="category.php" class="nav-link <?php echo $current_page == 'category.php' ? 'active bg-white text-success fw-bold' : 'text-white' ?>">
                        <i class="bi bi-tags me-2"></i> Categories
                    </a>
                </li>
                <li>
                    <a href="users.php" class="nav-link <?php echo $current_page == 'users.php' ? 'active bg-white text-success fw-bold' : 'text-white' ?>">
                        <i class="bi bi-people me-2"></i> Users
                    </a>
                </li>
                <li>
                    <a href="message.php" class="nav-link <?php echo $current_page == 'message.php' ? 'active bg-white text-success fw-bold' : 'text-white' ?>">
                        <i class="bi bi-envelope me-2"></i> Message
                    </a>
                </li>
            </ul>

            <hr>
            <div class="mt-auto">
                <a href="components/_logout.php" class="btn btn-danger w-100 fw-bold"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
            </div>
        </div>

        <div class="w-100 overflow-auto">
            <div class="d-flex justify-content-between align-items-center p-3 bg-white shadow-sm mb-4">
                <h5 class="m-0 fw-bold text-dark">Dashboard Overview</h5>
                <div class="d-flex align-items-center">
                    <span class="me-3 d-none d-sm-inline fw-bold text-success">Hello, <?php echo $admin ?></span>
                    <i class="bi bi-person-circle fs-4 text-success"></i>
                </div>
            </div>