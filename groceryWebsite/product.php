<?php include 'partials/_navbar.php';
// session_start();
$prod_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

$sql = "SELECT products.*, categories.category_name FROM products JOIN categories ON products.category_id = categories.id WHERE products.id = $prod_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['id'];
        $imageMain = $row['image'];
        $price = $row['price'];
        $old_price = $row['old_price'];
        $stock = $row['stock'];
        $productName = $row['product_name'];
        $updated_name = explode('-', $productName);
        $categoryId = $row['category_id'];
        $categoryName = $row['category_name'];
        $desc = $row['product_desc'];
    }
}

$sqlProduct = "SELECT * FROM detailsproduct WHERE product_id = $product_id";
$productResult = mysqli_query($conn, $sqlProduct);
if (mysqli_num_rows($productResult) > 0) {
    while ($productRow = mysqli_fetch_assoc($productResult)) {
        $image1 = $productRow['thumb_img1'];
        $image2 = $productRow['thumb_img2'];
        $image3 = $productRow['thumb_img3'];
        $image4 = $productRow['thumb_img4'];
        $facts = $productRow['detail_desc'];
    }
}
?>

<div class="product-page-wrapper" style="min-height: 80vh; background-color: #f8f9fa;">
    <div class="container py-5">
        <!-- nav bar for directory view (maybe i will remove it) -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-success">Home</a></li>
                <li class="breadcrumb-item"><a href="shop.php" class="text-decoration-none text-success">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $productName ?></li>
            </ol>
        </nav>
        <!-- the main product container starts here -->
        <div class="row bg-white p-4 rounded shadow-sm">
            <!-- images of the product -->
            <!-- this whole div comes from fetching data -->
            <div class="col-md-6">
                <div class="d-flex flex-column flex-md-row"">
                    <!-- small image boxes in the left corner of the main image -->
                    <div class="d-flex flex-column gap-2 me-3" id="product-images">
                        <img src="partials/images/productImages/<?php echo $imageMain ?>" class="thumb-img active" alt="thumb1">
                        <img src="partials/images/productImages/<?php echo $image1 ?>" class="thumb-img" alt="thumb2">
                        <img src="partials/images/productImages/<?php echo $image2 ?>" class="thumb-img" alt="thumb3">
                        <img src="partials/images/productImages/<?php echo $image3 ?>" class="thumb-img" alt="thumb4">
                        <img src="partials/images/productImages/<?php echo $image4 ?>" class="thumb-img" alt="thumb4">
                    </div>

                    <!-- the actual main image -->
                    <div class="main-img-container position-relative flex-grow-1 d-flex align-items-center justify-content-center">
                        <?php if ($old_price > $price) {
                            $discount_amount = $old_price - $price;
                            $discount_percent = round(($discount_amount / $old_price) * 100);
                        ?>
                            <div class="position-absolute top-0 end-0 badge bg-danger m-3 px-3 py-2 fs-6 shadow-sm z-1">
                                <?php echo $discount_percent; ?>% OFF
                            </div>
                        <?php } ?>
                        <img src="partials/images/productImages/<?php echo $imageMain ?>" id="mainImage" class="img-fluid" style="height: 400px; cursor: crosshair;" alt="Main Product">
                    </div>
                </div>
            </div>

            <!-- product details and add to cart button including quantity inputs -->
            <div class="col-md-6 ps-md-5 mt-4 mt-md-0 position-relative">

                <div id="zoomResult"></div> <!-- zoomed contain div -->

                <h6 class="text-muted">Fresh <?php echo $categoryName ?></h6> <!--comes from database (category name) -->
                <h2 class="fw-bold"><?php echo $updated_name[1] ?? $productName ?></h2> <!--comes from database (product name) -->

                <div class="my-3">
                    <?php
                    $unitWhat = $categoryId == '4' ? 'liter' : 'kg'; 
                    ?>

                    <?php if ($old_price > $price): ?>
                        <h3 class="mb-0">
                            <span class="text-muted text-decoration-line-through me-2 fs-5">₹<?php echo $old_price; ?></span>
                            <span class="text-success fw-bold">₹<?php echo $price; ?></span>
                            <span class="fs-6 text-muted fw-normal">/ <?php echo $unitWhat; ?></span>
                        </h3>
                    <?php else: ?>
                        <h3 class="text-success fw-bold">₹<?php echo $price ?> <span class="fs-6 text-muted fw-normal">/ <?php echo $unitWhat; ?></span></h3>
                    <?php endif; ?>
                </div>

                <!-- should come from database but i will handel it later -->
                <p class="text-muted">
                    <?php
                    $parts = explode('.', $desc);
                    echo $parts[0] . '. ' . $parts[1] . '.';

                    //cart quantity manage
                    $in_cart  = false;
                    $current_qty = 1;
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                        $uid = $_SESSION['user_id'];
                        $cartSql = "SELECT `qty` FROM `carts` WHERE `user_id` = '$uid' AND `product_id` = '$product_id'";
                        $cartRes = mysqli_query($conn, $cartSql);

                        if (mysqli_num_rows($cartRes) > 0) {
                            $cRow = mysqli_fetch_assoc($cartRes);
                            $in_cart = true;
                            $current_qty = $cRow['qty'];
                        }
                    }
                    ?>
                </p>

                <hr>
                <!-- the quantity and add to cart button div -->
                <div class="d-flex align-items-center mt-4">
                    <span class="me-3 fw-bold">Quantity:</span>
                    <!-- quantity button and display -->
                    <div class="btn-group <?php echo $in_cart ? 'pe-none opacity-50' : '' ?>" role="group" id="qtyDiv">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                        <input type="number" class="qty-input" id="productQty" value="<?php echo $current_qty ?>" min="1" max="12">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                    </div>
                    <!-- cart button -->
                    <button class="btn btn-success ms-4 px-4 <?php echo $in_cart ? 'visually-hidden' : '' ?>" id="add-cart" data-id="<?php $product_id ?>">
                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                    </button>
                    <button class="btn btn-danger ms-4 px-4 <?php echo $in_cart ? '' : 'visually-hidden'  ?>" id="remove-cart" data-id="<?php $product_id ?>">
                        <i class="fas fa-shopping-cart me-2"></i> Remove
                    </button>
                </div>

                <!-- category name and instock details -->
                <div class="mt-4">
                    <p class="mb-1"><strong class="text-dark">Category:</strong> <span class="text-muted"><?php echo $categoryName ?></span></p> <!--comes from database (categoryName) -->
                    <p class="mb-1"><strong class="text-dark">Stock:</strong> <span class="text-success"><?php echo $stock ?></span></p> <!--comes from database (stock) -->
                </div>
            </div>
        </div>

        <!-- feature boxes -->
        <div class="container my-3">
            <h4 class="fw-bold py-3">Why choose PureGrocery?</h4>
            <div class="row g-2 text-center">
                <div class="col-6 col-md-3">
                    <div class="p-3 border rounded bg-white h-100 shadow-sm">
                        <i class="fas fa-leaf text-success fs-4 mb-2"></i>
                        <h6 class="fw-bold mb-1">100% Organic</h6>
                        <p class="text-muted small m-0" style="font-size: 12px;">Sourced from farms.</p>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="p-3 border rounded bg-white h-100 shadow-sm">
                        <i class="fas fa-shipping-fast text-success fs-4 mb-2"></i>
                        <h6 class="fw-bold mb-1">Fast Delivery</h6>
                        <p class="text-muted small m-0" style="font-size: 12px;">Within 24 hours.</p>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="p-3 border rounded bg-white h-100 shadow-sm">
                        <i class="fas fa-tags text-success fs-4 mb-2"></i>
                        <h6 class="fw-bold mb-1">Best Prices</h6>
                        <p class="text-muted small m-0" style="font-size: 12px;">Amazing daily deals.</p>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="p-3 border rounded bg-white h-100 shadow-sm">
                        <i class="fas fa-headset text-success fs-4 mb-2"></i>
                        <h6 class="fw-bold mb-1">Support 24/7</h6>
                        <p class="text-muted small m-0" style="font-size: 12px;">Contact us anytime.</p>
                    </div>
                </div>
            </div>
        </div>

        
        <!-- description and review div started -->
        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active text-success" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-success" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button">Reviews</button>
                    </li>
                </ul>
                <div class="tab-content p-4 bg-white border border-top-0" id="myTabContent">
                    <div class="tab-pane fade show active" id="desc" role="tabpanel">
                        <h5>Nutritional Facts</h5>
                        <p><?php
                            if ($facts) {
                                echo $facts;
                            } else {
                                echo "This is the detailed description of the product. Here you can write about the nutritional values, origin, and benefits of the item.";
                            }
                            ?>
                        </p>
                    </div>

                    <div class="tab-pane fade" id="review" role="tabpanel">
                        <?php
                        $review_form_html = '';

                        // login check
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

                            $uid = $_SESSION['user_id'];

                            // order status check

                            $check_deliver_sql = "SELECT orders.order_status 
                              FROM `orders` JOIN `order_items` ON orders.order_id = order_items.order_id 
                              WHERE orders.user_id = '$uid' AND order_items.product_id = '$product_id'";

                            $deliver_res = mysqli_query($conn, $check_deliver_sql);

                            if (mysqli_num_rows($deliver_res) > 0) {
                                // check status of ordered..
                                $order_data = mysqli_fetch_assoc($deliver_res);
                                $status = $order_data['order_status'];
                                if ($status == 'Delivered') {
                                    // ordered delivered -> now check already review or not

                                    $unique_check = "SELECT * FROM `reviews` WHERE `user_id`='$uid' AND `product_id`='$product_id'";
                                    $unique_res = mysqli_query($conn, $unique_check);

                                    if (mysqli_num_rows($unique_res) > 0) {
                                        // already reviewed -> thanks message
                                        $review_form_html = '
                                            <div class="alert alert-success text-center p-4 border-0 bg-light">
                                                <i class="fas fa-check-circle fs-1 text-success mb-3"></i>
                                                <h6 class="fw-bold text-dark">Thanks for your feedback!</h6>
                                                <p class="mb-0 text-muted small">You have already submitted a review for this product.</p>
                                            </div>';
                                    } else {
                                        // no review -> show the form

                                        $stars_html = '';
                                        for ($i = 1; $i <= 5; $i++) {
                                            $stars_html .= '
                                            <input type="radio" class="btn-check" name="rating" 
                                            id="star' . $i . '" value="' . $i . '" required>
                                            <label class="btn btn-outline-warning" for="star' . $i . '">
                                            ' . $i . '<i class="bi bi-star-fill"></i></label>';
                                        }
                                        $review_form_html = '
                                            <form id="reviewForm">
                                                <input type="hidden" name="product_id" value="' . $product_id . '">
                                                <div class="mb-3">
                                                    <label class="form-label d-block fw-bold small text-muted">YOUR RATING</label>
                                                    <div class="btn-group" role="group">
                                                        ' . $stars_html . '
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small text-muted">YOUR REVIEW</label>
                                                    <textarea class="form-control" name="review_text" rows="3" placeholder="Write your experience..." required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-success w-100 fw-bold">Submit Review</button>
                                            </form>';
                                    }
                                } else {
                                    // ordered but not delivered yet
                                    $review_form_html = '
                                            <div class="alert alert-info text-center p-4 border-0 bg-light">
                                                <i class="fas fa-truck text-info fs-1 mb-3"></i>
                                                <h6 class="fw-bold text-dark">On the way!</h6>
                                                <p class="mb-0 text-muted small">You can write a review once the product is delivered.</p>
                                            </div>';
                                }
                            } else {
                                // not ordered
                                $review_form_html = '
                                    <div class="alert alert-warning text-center p-4 border-0 bg-light">
                                        <i class="fas fa-shopping-bag fs-1 text-muted mb-3"></i>
                                        <h6 class="fw-bold text-dark">Haven\'t purchased this?</h6>
                                        <p class="mb-0 text-muted small">Only verified buyers can write reviews for this product.</p>
                                    </div>';
                            }
                        } else {
                            // not loggined
                            $review_form_html = '
                            <div class="alert alert-light border text-center p-4">
                                <p class="mb-2 small text-muted">Please login to write a review.</p>
                                <button onclick="openPopup(\'loginOverlay\')" class="btn btn-outline-primary btn-sm px-4">Login Now</button>
                            </div>';
                        }

                        // final output
                        echo '
                            <div class="row pt-3">
                                <div class="col-md-7 border-end">
                                    <h5 class="mb-4">Customer Reviews</h5>
                                    <div id="review-list">
                                        <div class="text-center py-4 text-muted">
                                            <div class="spinner-border spinner-border-sm text-success" role="status"></div> Loading reviews...
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 ps-md-4 mt-4 mt-md-0">
                                    <h5 class="mb-3">Write a Review</h5>
                                    ' . $review_form_html . '
                                </div>
                            </div>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- description and review div end -->
    </div>
</div>
<script>
    // product id for getting add to cart count
    let productId = <?php echo $product_id ?>;
</script>
<script src="assets/review.js"></script>
<script src="https://cdn.jsdelivr.net/npm/drift-zoom@1.5.1/dist/Drift.min.js"></script>


<?php include 'partials/_footer.php' ?>