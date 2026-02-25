<?php
session_start();
include '_dbconnect.php';

// if(!isset($_SESSION['cart'])){
//     $_SESSION['cart'] = [];
// }

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    echo '
    <div class="text-center py-5 bg-white shadow-sm rounded">
        <img src="https://rukminim2.flixcart.com/www/800/800/promos/16/05/2019/08dddd59-c0ff-4efd-8723-6d847f5df25f.png?" style="width: 200px; opacity: 0.7;" alt="Empty Cart">
        <h4 class="mt-3">Missing Cart items?</h4>
        <p class="text-muted">Login to see the items you added previously</p>
        
        <button onclick="openPopup(\'loginOverlay\')" class="btn btn-warning px-5 mt-2 fw-bold text-white">Login Now</button>
    </div>';
    exit();
}
$user_id = $_SESSION['user_id'];
//============================================
//check the count of add to cart and update it
//============================================
if (isset($_POST['add_id'])) {
    $pid = $_POST['add_id'];


    $qty = isset($_POST['qty']) ? intval($_POST['qty']) : 1;
    $_SESSION['cart'][$pid] = $qty;
    //inside $_SESSION['cart'] => {[2] => 3, [3] => 1}         <--([$pid] => $qty])-->
    //check the stock count
    $stockSql = "SELECT stock FROM `products` WHERE id = '$pid'";
    $stockRes = mysqli_query($conn, $stockSql);
    $productRow = mysqli_fetch_assoc($stockRes);
    $currentStock = $productRow['stock'];
    //check exist cart count
    $checkCart = mysqli_query($conn, "SELECT qty FROM `carts` WHERE `user_id` = '$user_id' AND `product_id` = $pid");
    $cartQty = 0;
    if (mysqli_num_rows($checkCart) > 0) {
        $cartRow = mysqli_fetch_assoc($checkCart);
        $cartQty = $cartRow['qty'];
    }
    // stock check
    if ($qty > 0 && ($cartQty + $qty) > $currentStock) {
        echo "out_of_stock";
        exit();
    }

    //update or insert
    if (mysqli_num_rows($checkCart) > 0) {
        mysqli_query($conn, "UPDATE `carts` SET `qty` = `qty` + '$qty' WHERE `user_id`='$user_id' AND `product_id` = '$pid'");
    } else {
        mysqli_query($conn, "INSERT INTO `carts` (user_id, product_id, qty) VALUES ('$user_id', '$pid', '$qty')");
    }

    //return count from database
    $countSql = "SELECT COUNT(*) as count FROM `carts` WHERE `user_id` = '$user_id'";
    $countRes = mysqli_query($conn, $countSql);
    $row = mysqli_fetch_assoc($countRes);

    echo $row['count'];
    exit();
}


//=======================================================
//check the count of remove item form cart and update it
//=======================================================
if (isset($_POST['remove_id'])) {
    $pid = intval($_POST['remove_id']);

    mysqli_query($conn, "DELETE FROM `carts` WHERE `user_id` = '$user_id' AND `product_id` = '$pid'");

    $countSql = "SELECT COUNT(*) as count FROM `carts` WHERE `user_id` = '$user_id'";
    $countRes = mysqli_query($conn, $countSql);
    $row = mysqli_fetch_assoc($countRes);

    echo $row['count'];
    exit();
}

//======================================
//fetch cart view directly from database
//======================================

if (isset($_POST['fetch_cart_view'])) {

    $cartItems = [];
    $sql = "SELECT * FROM `carts` WHERE `user_id` = '$user_id'";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $cartItems[$row['product_id']] = $row['qty'];
    }
    if (empty($cartItems)) {
        echo '
        <div class="text-center py-5 bg-white shadow-sm rounded">
            <img src="https://rukminim2.flixcart.com/www/800/800/promos/16/05/2019/08dddd59-c0ff-4efd-8723-6d847f5df25f.png?" style="width: 200px; opacity: 0.7;" alt="Empty Cart">
            <h4 class="mt-3">Your cart is empty!</h4>
            <p class="text-muted">Add items to it now.</p>
            <a href="index.php" class="btn btn-success px-5 mt-2">Shop Now</a>
        </div>';
        exit();
    }

    $product_ids = array_keys($cartItems);
    $ids_string = implode(',', $product_ids);

    $sql = "SELECT * FROM products WHERE id IN ($ids_string)";
    $result = mysqli_query($conn, $sql);

    $total_amount = 0;
    $delivery_charge = 0;

    $item_html = '';

    while ($row = mysqli_fetch_assoc($result)) {
        $pro_id = $row['id'];
        $name = $row['product_name'];
        $image = $row['image'];
        $price = $row['price'];
        $unit = ($row['category_id'] == 4) ? 'L' : 'kg';

        $qty = $cartItems[$pro_id];
        $item_total = $price * $qty;
        $total_amount += $item_total;

        $item_html .= '
            <div class="cart-item-card p-3 d-flex flex-column flex-md-row align-items-center gap-3">
                <div style="width: 100px; height: 100px; flex-shrink: 0;">
                    <img src="partials/images/productImages/' . $image . '"
                        class="img-fluid w-100 h-100" style="object-fit: contain;" alt="Product">
                </div>

                <div class="flex-grow-1 w-100">
                    <h6 class="mb-1">' . $name . ' (' . $unit . ')</h6>
                    <small class="text-muted">Price: ₹' . $price . ' / ' . $unit . '</small>

                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div class="price-box">₹' . $item_total . '</div>
                        <div class="cart-qty-action d-flex align-items-center" data-id="' . $pro_id . '">
                            <button class="btn btn-sm border cart-qty-dec">-</button>
                            <input type="text" class="qty-input form-control form-control-sm mx-1 text-center" 
                            style="width:40px;" value="' . $qty . '" max="12" readonly>
                            <button class="btn btn-sm border cart-qty-inc">+</button>
                        </div>
                    </div>
                </div>

                <div class="ms-md-3 mt-3 mt-md-0">
                    <button class="btn text-danger fw-bold hover-effect cart-remove-btn" data-id="' . $pro_id . '">
                        <i class="fas fa-trash me-1"></i> Remove
                    </button>
                </div>
            </div>';
    }

    //new code write here
    $display_address = "Please select an address";
    $display_type = "NONE";

    if (isset($_SESSION['active_address_id'])) {
        $aid = $_SESSION['active_address_id'];
        $addr_sql = "SELECT * FROM `user_address` WHERE `id` = '$aid' AND `user_id` = '$user_id'";
    } else {
        $addr_sql = "SELECT * FROM `user_address` WHERE `user_id` = '$user_id' LIMIT 1";
    }

    $addr_res = mysqli_query($conn, $addr_sql);

    if ($addr_row = mysqli_fetch_assoc($addr_res)) {
        $display_address = $addr_row['name'] . ', ' . $addr_row['address_line1'] . ', ' . $addr_row['pincode'];
        $display_type = strtoupper($addr_row['address_type']);
        if (!isset($_SESSION['active_address_id'])) $_SESSION['active_address_id'] = $addr_row['id'];
    }

    $disable = false;
    if (!isset($_SESSION['active_address_id'])) {
        $disable = true;
    } 

    echo '
            <div class="row">
            <div class="col-md-8">
            <div class="address-bar d-flex justify-content-between align-items-center shadow-sm p-3 mb-3 bg-white rounded">
                <div class="d-flex align-items-center text-truncate" style="max-width: 80%;">
                    <div class="bg-light rounded-circle p-2 me-3 text-secondary">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">
                            Deliver to: <span class="badge bg-light text-dark border">' . $display_type . '</span>
                        </small>
                        <span class="fw-bold text-dark text-truncate d-block" title="' . $display_address . '">
                            ' . $display_address . '
                        </span>
                    </div>
                </div>
                <button class="btn btn-outline-success btn-sm px-3" onclick="openAddressManager()">Change</button>
            </div>

            <div class="bg-white shadow-sm rounded mb-4">
                <h5 class="p-3 border-bottom m-0">My Cart (' . count($cartItems) . ')</h5>
                ' . $item_html . '
            </div>
        </div>

        <div class="col-md-4">
            <div class="side-stick">
                <div class="summary-card p-3 ">
                    <h5 class="text-muted mb-3 border-bottom pb-2">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><span>₹' . $total_amount . '</span></div>
                    <div class="d-flex justify-content-between mb-3"><span>Delivery Charges</span><span class="text-success">FREE</span></div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total Amount</span>
                        <span class="fw-bold fs-5">₹' . ($total_amount + $delivery_charge) . '</span>
                    </div>';
    if ($disable) {
        echo '
                        <button class="btn btn-success w-100 py-2 fw-bold text-uppercase shadow-sm pe-none opacity-50">
                        Proceed to Checkout</button>
                        ';
    } else {
        // total and count
        $final_total = $total_amount + $delivery_charge;
        $total_items = count($cartItems);

        echo '
        <button onclick="openCheckoutModal('.$final_total.', '.$total_items.')" 
            class="btn btn-success w-100 py-2 fw-bold text-uppercase shadow-sm">
            Proceed to Checkout
        </button>';
    }

    echo '
                </div>
                
                <div class="mt-3 text-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/MasterCard_Logo.svg/1200px-MasterCard_Logo.svg.png" width="30" class="mx-1 opacity-50">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Visa_Inc._logo_%282021%E2%80%93present%29.svg" width="30" class="mx-1 opacity-50">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/UPI-Logo-vector.svg/1200px-UPI-Logo-vector.svg.png" width="30" class="mx-1 opacity-50">
                    <span class="text-muted small ms-2">100% Secure Payment</span>
                </div>
            </div>
        </div>
    </div>';

    exit();
}
