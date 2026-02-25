<?php include 'partials/_navbar.php' ?>
<div class="cart-container my-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-success">Home</a></li>
            <li class="breadcrumb-item"><a href="shop.php" class="text-decoration-none text-success">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cart</li>
        </ol>
    </nav>

    <div id="dynamic-cart-content" style="min-height: 80vh;">
    </div>
    <?php include 'partials/_address.php' ?>

    <!-- checkout popup -->
    <div id="checkoutOverlay" class="auth-overlay">
        <div class="auth-box" style="max-width: 400px;">
            <span class="close-icon" onclick="closePopup('checkoutOverlay')">&times;</span>

            <h4 class="mb-3 fw-bold text-center">Checkout</h4>

            <div class="alert alert-info py-2 small text-center">
                You are placing an order for <b><span id="checkout_total_items">0</span> items</b>.
            </div>

            <form id="placeOrderForm" onsubmit="placeOrder(event)">

                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">PAYMENT METHOD</label>

                    <div class="border rounded p-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="payCOD" value="COD" checked>
                            <label class="form-check-label fw-bold" for="payCOD">
                                Cash on Delivery (COD)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 mt-4 border-top pt-3">
                    <span class="h5 mb-0 text-muted">Total Amount</span>
                    <span class="h4 mb-0 fw-bold text-success">₹<span id="checkout_final_amount">0</span></span>
                </div>

                <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow">
                    CONFIRM ORDER <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </form>

        </div>
    </div>
    
</div>
<script src="assets/cart.js"></script>
<script src="assets/address.js"></script>
<?php include 'partials/_footer.php' ?>