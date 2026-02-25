<?php
session_start();
include 'partials/_dbconnect.php';

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$product_parent_param = isset($_GET['product_parent']) ? $_GET['product_parent'] : null;

if ($product_parent_param) {
    $sql = "SELECT products.*, categories.category_name FROM products JOIN categories ON products.category_id = categories.id WHERE products.parent_product LIKE '%$product_parent_param%' AND products.stock > 0;";
} elseif ($category_id) {

    if ($category_id == 'all') {
        $sql = "SELECT products.*, categories.category_name FROM products JOIN categories ON products.category_id = categories.id WHERE products.stock > 0;";
    } else {
        $sql = "SELECT products.*, categories.category_name FROM products JOIN categories ON products.category_id = categories.id WHERE products.category_id = $category_id AND products.stock > 0;";
    }
}

if ($sql) {

    $userCartItem = [];
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $uid = $_SESSION['user_id'];
        $cartSql = "SELECT product_id FROM `carts` WHERE `user_id` = '$uid'";
        $cartRes = mysqli_query($conn, $cartSql);
        while ($cRow = mysqli_fetch_assoc($cartRes)) {
            $userCartItem[] = $cRow['product_id'];
        }
    }

    $result = mysqli_query($conn, $sql);
    $gridHtml = '';
    $sideBarArray = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $product_name = $row['product_name'];
        $product_id = $row['id'];
        $cat_name = $row['category_name'];
        $parent_product = $row['parent_product'];
        $unitDecider = $row['category_id'];
        $unitWhat = $unitDecider == '4' ? 'liter' : 'kg';
        $price = $row['price'];
        $old_price = $row['old_price'];
        $image = $row['image'];
        $btnHtml = '';
        if (in_array($product_id, $userCartItem)) {
            // if in cart
            $btnHtml = '<button class="btn btn-danger w-100 global-remove-from-cart" data-id="' . $product_id . '">Remove</button>';
        } else {
            // if not in cart
            $btnHtml = '<button class="btn btn-success w-100 global-add-to-cart" data-id="' . $product_id . '">Add to Cart</button>';
        }

        //=======================
        //discount & price logic
        //=======================
        $discount_badge_html = '';
        $price_html = '';

        if($old_price > $price){
            $discount_ammount = $old_price - $price;
            $discount_percent = round(($discount_ammount / $old_price) * 100);

            $discount_badge_html = '<div class="position-absolute top-0 end-0 badge bg-danger m-2 px-2 py-1" style="font-size: 0.8rem;">' . $discount_percent . '% OFF</div>';
            
            // new price and old price(cut)
            $price_html = '
                <span class="text-muted text-decoration-line-through me-1" style="font-size: 0.9rem;">₹' . $old_price . '</span>
                <strong class="fw-bold text-success fs-5">₹' . $price . '</strong>
                <span class="text-muted small"> / ' . $unitWhat . '</span>
            ';
        }else{
            $price_html = '
                <strong class="fw-bold text-dark fs-5">₹' . $price . '</strong>
                <span class="text-muted small"> / ' . $unitWhat . '</span>
            ';
        }


        $gridHtml .= '
            <div class="card position-relative">
                '.$discount_badge_html.'
                <a href="product.php?product_id=' . $product_id . '" target="_blank"><img src="partials/images/productImages/' . $image . '" class="card-img-top" alt="' . $product_name . '"></a>
                <div class="card-body">
                    <h5 class="card-title">' . $product_name . '</h5>
                    <p class="card-text mb-3">'.$price_html.'</p>
                    ' . $btnHtml . '
                </div>
            </div>
        ';
        //side bar data
        // looks like this: ['Vegetables' => ['Potato', 'Tomato'], 'Fruits' => ['Apple']]
        if (!isset($sideBarArray[$cat_name])) {
            $sideBarArray[$cat_name] = [];
        }
        if (!in_array($parent_product, $sideBarArray[$cat_name])) {
            $sideBarArray[$cat_name][] = $parent_product;
        }
    }

    //send response as json

    $response = [
        'gridHtml' => $gridHtml,
        'sidebarData' => $sideBarArray
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
}
