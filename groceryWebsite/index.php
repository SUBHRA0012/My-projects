<?php include 'partials/_navbar.php'; 

$userCartItem = [];
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    $uid = $_SESSION['user_id'];
    $cartSql = "SELECT product_id FROM `carts` WHERE `user_id` = '$uid'";
    $cartRes = mysqli_query($conn, $cartSql);
    while($cRow = mysqli_fetch_assoc($cartRes)){
        $userCartItem[] = $cRow['product_id'];
    }
}

?>

<section class="hero-section">
    <div class="hero-overlay">
        <div class="container text-center text-white hero-content">
            <h1 class="fw-bold display-4">Freshness Delivered</h1>
            <p class="fs-4 mt-3 mb-4 opacity-75">Organic, fresh, and affordable groceries at your doorstep.</p>
            <a href="shop.php" class="btn btn-success btn-lg rounded-pill px-5 py-3 shadow">
                Shop Now <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<section class="container mb-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-box">
                <div class="feature-icon"><i class="fas fa-leaf"></i></div>
                <h5 class="fw-bold">100% Organic</h5>
                <p class="text-muted small">We source our products directly from organic farms.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <div class="feature-icon"><i class="fas fa-shipping-fast"></i></div>
                <h5 class="fw-bold">Fast Delivery</h5>
                <p class="text-muted small">Get your groceries delivered within 24 hours.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <div class="feature-icon"><i class="fas fa-tags"></i></div>
                <h5 class="fw-bold">Best Prices</h5>
                <p class="text-muted small">Affordable prices with amazing daily deals.</p>
            </div>
        </div>
    </div>
</section>

<div class="container mb-5" id="products">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark m-0">Super Saver Deals</h2>
        <a href="shop.php" class="btn btn-outline-success rounded-pill btn-sm">View All</a>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2 g-md-4">

        <?php
        $query = 'SELECT * FROM `products` WHERE `old_price` > `price` LIMIT 8'; 
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo '<div class="alert alert-danger">Error: ' . mysqli_connect_error() . '</div>';
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $product_name = $row['product_name'];
            $product_id = $row['id'];
            $price = $row['price'];
            $image = $row['image'];
            $unitDecider = $row['category_id'];
            $discount_amount = $row['old_price'] - $price;
            $discount_percent = round(($discount_amount / $row['old_price']) * 100);
            $unitWhat = $unitDecider == '4' ? 'liter' : 'kg';
            
            if (in_array($product_id, $userCartItem)) {
                $btnHtml = '<button class="btn btn-danger w-100 global-remove-from-cart" data-id="' . $product_id . '">Remove</button>';
            }else{
                $btnHtml = '<button class="btn btn-success w-100 global-add-to-cart" data-id="' . $product_id . '">Add to Cart</button>';
            }

           echo '
            <div class="col">
                <div class="card product-card h-100 position-relative">
                    
                    <div class="position-absolute top-0 end-0 badge bg-danger m-2 px-2 py-1" style="font-size: 0.8rem;">
                        ' . $discount_percent . '% OFF
                    </div>

                    <a href="product.php?product_id=' . $product_id . '" target="_blank">
                        <img src="partials/images/productImages/' . $image . '" class="card-img-top" alt="' . $product_name . '">
                    </a>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-1">' . $product_name . '</h5>
                        
                        <div class="mb-3 mt-auto">
                            <span class="text-muted text-decoration-line-through me-1" style="font-size: 0.9rem;">₹' . $row['old_price'] . '</span>
                            <span class="fw-bold text-success fs-5">₹' . $price . '</span>
                            <span class="text-muted small"> / ' . $unitWhat . '</span>
                        </div>
                        
                        '.$btnHtml.'            
                    </div>
                </div>
            </div>';
        }
        ?>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
//  show if logout=true 
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    echo "
    <script>
        Swal.fire({
            title: 'Logged Out!',
            text: 'You have been successfully logged out.',
            icon: 'success',
            confirmButtonColor: '#198754', 
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                window.history.replaceState(null, null, window.location.pathname);
            }
        });
    </script>
    ";
}
// show if ban=true (user banned)
if (isset($_GET['ban']) && $_GET['ban'] == 'true') {
    echo "
    <script>
        Swal.fire({
            title: 'Account Suspended!',
            html: 'You have been <b>banned</b> from accessing this website by the Admin.<br><br>If you think this is a mistake, 
            please <a href=\"contUs.php\" style=\"color: #0d6efd; text-decoration: underline; font-weight: bold;\">Contact Us</a>.',
            icon: 'error',
            confirmButtonColor: '#dc3545', 
            confirmButtonText: 'Close',
            allowOutsideClick: false 
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                window.history.replaceState(null, null, window.location.pathname);
            }
        });
    </script>
    ";
}
?>
<?php include 'partials/_footer.php' ?>