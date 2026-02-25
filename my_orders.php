<?php
include 'partials/_navbar.php';


if (!isset($_SESSION['user_id'])) {
    header('location: index.php');
    exit;
}
$uid = $_SESSION['user_id'];
?>



<div class="orders-wrapper">
    <div class="container">
        <div class="row">
            <!-- filter box -->
            <div class="text-center mb-3">
                <button class="btn btn-success d-md-none fw-bold shadow-sm px-4"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#orderFilterMobile"
                    aria-controls="orderFilterMobile">
                    <i class="fas fa-filter me-2"></i> Filter Orders
                </button>
            </div>

            <div class="col-md-3 mb-3">
                <div class="filter-sidebar offcanvas-md offcanvas-start bg-white" id="orderFilterMobile" tabindex="-1">

                    <div class="offcanvas-header d-md-none border-bottom mb-2">
                        <h5 class="offcanvas-title fw-bold">Filters</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#orderFilterMobile"></button>
                    </div>

                    <div class="offcanvas-body flex-column p-0">
                        <div class="small fw-bold text-muted mb-2">STATUS</div>
                        <div class="form-check mb-1">
                            <input class="form-check-input status-check" id="statusPlaced" type="checkbox" value="Placed" onchange="filterOrders()">
                            <label for="statusPlaced" class="form-check-label small">Placed / On Way</label>
                        </div>
                        <div class="form-check mb-1">
                            <input class="form-check-input status-check" id="statusDelivered" type="checkbox" value="Delivered" onchange="filterOrders()">
                            <label for="statusDelivered" class="form-check-label small">Delivered</label>
                        </div>
                        <div class="form-check mb-1">
                            <input class="form-check-input status-check" id="statusCancelled" type="checkbox" value="Cancelled" onchange="filterOrders()">
                            <label class="form-check-label small" for="statusCancelled">Cancelled</label>
                        </div>

                        <div class="small fw-bold text-muted border-top pt-2 mt-2 mb-2">TIME</div>
                        <div class="form-check mb-1">
                            <input class="form-check-input time-check" id="timeRecent" type="checkbox" value="recent" onchange="filterOrders()">
                            <label class="form-check-label small" for="timeRecent">Last 30 Days</label>
                        </div>
                        <div class="form-check mb-1">
                            <input class="form-check-input time-check" id="timeOld" type="checkbox" value="old" onchange="filterOrders()">
                            <label class="form-check-label small" for="timeOld">Older</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- right side content -->
            <div class="col-md-9">

                <!-- search bar -->
                <div class="search-container">
                    <div class="search-icon-box"><i class="fas fa-search"></i></div>
                    <input type="text" class="search-input" oninput="filterOrders()" placeholder="Search by Order ID or Product...">
                    <button class="search-btn">Search</button>
                </div>

                <?php
                $sql = "SELECT * FROM `orders` WHERE `user_id` = '$uid' ORDER BY `order_id` DESC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    //(parent) order div while loop started
                    while ($row = mysqli_fetch_assoc($result)) {

                        // ==========================================
                        //  PHP LOGIC SECTION
                        // ==========================================

                        $db_id = $row['order_id'];
                        $display_id = $row['order_ref_id'];
                        $amount = $row['total_amount'];
                        $status = isset($row['order_status']) ? $row['order_status'] : 'Placed';
                        $date = date("M d, Y", strtotime($row['dt']));
                        $is_recent = (strtotime($row['dt']) > strtotime('-30 Days')) ? 'recent' : 'old';
                        // default styles
                        $theme_color = "primary";
                        $icon_class = "truck";
                        $text_class = "text-dark";
                        $bg_class = "";
                        $badge_style = "bg-primary bg-opacity-10 text-primary";
                        $is_cancelled = false;

                        // status logic
                        if ($status == "Delivered") {
                            $theme_color = "success";
                            $icon_class = "check";
                            $badge_style = "bg-success bg-opacity-10 text-success";
                        } elseif ($status == "Cancelled") {
                            $theme_color = "danger";
                            $icon_class = "times-circle";
                            $text_class = "text-danger";
                            $bg_class = "bg-danger bg-opacity-10 border border-danger border-opacity-25";
                            $badge_style = "bg-danger text-white";
                            $is_cancelled = true;
                        }

                        // ============================
                        // TRACKER LOGIC
                        // ============================
                        $progress_width = 0;
                        $s1 = $s2 = $s3 = $s4 = ""; // step class

                        if ($status == 'Placed') {
                            $s1 = "active";
                            $progress_width = 0;
                        } elseif ($status == 'Shipped') {
                            $s1 = $s2 = "active";
                            $progress_width = 33;
                        } elseif ($status == 'Out for Delivery') {
                            $s1 = $s2 = $s3 = "active";
                            $progress_width = 66;
                        } elseif ($status == 'Delivered') {
                            $s1 = $s2 = $s3 = $s4 = "active";
                            $progress_width = 100;
                        }


                        $filter_status = ($status == 'Delivered' || $status == 'Cancelled') ? $status : 'Placed';
                ?>

                        <div class="card order-card-slim order-item" data-status="<?php echo $filter_status ?>" data-time="<?php echo $is_recent ?>">

                            <div class="card-body p-3 <?php echo $bg_class; ?>">

                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                    <div>
                                        <h6 class="mb-0 fw-bold <?php echo $text_class; ?>" style="font-size: 0.95rem;">
                                            #<?php echo $display_id; ?>
                                        </h6>
                                        <span class="meta-text <?php echo ($is_cancelled) ? 'text-danger text-opacity-75' : ''; ?>">
                                            Ordered on <?php echo $date; ?>
                                        </span>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge <?php echo $badge_style; ?> px-2 py-1 rounded-1" style="font-size: 0.75rem;">
                                            <i class="fas fa-<?php echo $icon_class; ?> me-1"></i> <?php echo $status; ?>
                                        </span>
                                        <div class="amount-text <?php echo ($is_cancelled) ? 'text-danger' : ''; ?>">₹<?php echo $amount; ?></div>
                                    </div>
                                </div>
                                <!-- progress bar of placed order (live progress bar) -->
                                <?php if (!$is_cancelled && $status != 'Delivered'): ?>
                                    <div class="track-container">
                                        <div class="track-line-bg"></div>
                                        <div class="track-line-active" style="width: <?php echo $progress_width; ?>%;"></div>
                                        <div class="track-steps">
                                            <div class="position-relative">
                                                <div class="track-step <?php echo $s1; ?>"></div><span class="track-text">Placed</span>
                                            </div>
                                            <div class="position-relative">
                                                <div class="track-step <?php echo $s2; ?>"></div><span class="track-text">Shipped</span>
                                            </div>
                                            <div class="position-relative">
                                                <div class="track-step <?php echo $s3; ?>"></div><span class="track-text">On Way</span>
                                            </div>
                                            <div class="position-relative">
                                                <div class="track-step <?php echo $s4; ?>"></div><span class="track-text">Delivered</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <a href="#d<?php echo $db_id; ?>" class="toggle-details-btn text-<?php echo $theme_color; ?>" data-bs-toggle="collapse">
                                    View Items <i class="fas fa-chevron-down ms-1"></i>
                                </a>

                                <div class="collapse mt-2" id="d<?php echo $db_id; ?>">
                                    <div class="bg-light p-3 rounded small border mt-2">

                                        <?php if ($is_cancelled): ?>
                                            <p class="text-danger fw-bold mb-3" style="font-size: 0.8rem;">
                                                <i class="fas fa-info-circle"></i> This order was cancelled.
                                            </p>
                                        <?php endif; ?>
                                        <!-- progress bar of dedlivered (static full bar) -->
                                        <?php if ($status == 'Delivered'): ?>
                                            <div class="track-container mb-4">
                                                <div class="track-line-bg"></div>
                                                <div class="track-line-active" style="width: 100%;"></div>
                                                <div class="track-steps">
                                                    <div class="position-relative">
                                                        <div class="track-step active"></div><span class="track-text">Placed</span>
                                                    </div>
                                                    <div class="position-relative">
                                                        <div class="track-step active"></div><span class="track-text">Shipped</span>
                                                    </div>
                                                    <div class="position-relative">
                                                        <div class="track-step active"></div><span class="track-text">On Way</span>
                                                    </div>
                                                    <div class="position-relative">
                                                        <div class="track-step active"></div><span class="track-text">Delivered</span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- items inside order div  -->
                                        <div class="row g-3">
                                            <?php
                                            $sql_items = "SELECT * FROM `order_items` JOIN `products` ON order_items.product_id = products.id WHERE `order_id` = '$db_id'";
                                            $res_items = mysqli_query($conn, $sql_items);
                                            if ($res_items && mysqli_num_rows($res_items) > 0) {
                                                //while loop of showing items inside order div started
                                                while ($item = mysqli_fetch_assoc($res_items)) {
                                                    $subtotal = $item['price'] * $item['qty'];
                                            ?>
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="bg-white border rounded p-2 h-100 d-flex align-items-center shadow-sm">
                                                            <div class="flex-shrink-0">
                                                                <img src="partials/images/productImages/<?php echo $item['image']; ?>"
                                                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #eee;"
                                                                    onerror="this.src='https://placehold.co/60'">
                                                            </div>
                                                            <div class="ms-3 d-flex flex-column justify-content-center">
                                                                <h6 class="mb-1 fw-bold text-dark lh-sm" style="font-size: 0.85rem;">
                                                                    <?php echo $item['product_name']; ?>
                                                                </h6>
                                                                <span class="text-muted mb-1" style="font-size: 0.75rem;">
                                                                    Qty: <?php echo $item['qty']; ?>
                                                                </span>
                                                                <span class="fw-bold text-success" style="font-size: 0.9rem;">
                                                                    ₹<?php echo $subtotal; ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                                //while loop end of item inside order div
                                            }
                                            ?>
                                        </div>
                                        <!-- invoice and cancel buttons -->
                                        <div class="mt-4 pt-3 border-top text-start">
                                            <?php if ($status == 'Delivered'): ?>
                                                <a href="partials/_invoice.php?id=<?php echo $db_id ?>" target="_blank" class="btn btn-sm btn-success text-white px-3">
                                                    <i class="fas fa-download me-1"></i> Invoice
                                                </a>
                                            <?php elseif (!$is_cancelled): ?>
                                                <a href="partials/_invoice.php?id=<?php echo $db_id ?>" target="_blank" class="btn btn-sm btn-outline-dark px-3 me-2">Invoice</a>
                                                <button onclick="cancelOrder(<?php echo $db_id; ?>)" class="btn btn-sm btn-outline-danger px-3">Cancel</button>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                <?php
                    } // End order div While
                } else {
                    echo '<div class="alert alert-warning text-center">You have no orders yet!</div>';
                }
                ?>

                <div id="no-orders-found" class="text-center mt-5" style="display: none;">
                    <div class="text-muted p-4">
                        <i class="fas fa-search fa-2x mb-3 text-secondary opacity-50"></i>
                        <h6 class="fw-bold">No orders found</h6>
                        <p class="small text-secondary">Try changing the filters or search term.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function filterOrders() {
        console.log('aai chosh');
        let statusList = Array.from(document.querySelectorAll('.status-check:checked')).map(e => e.value);
        let timeList = Array.from(document.querySelectorAll('.time-check:checked')).map(e => e.value);
        let searchInput = document.querySelector('.search-input');
        let search = searchInput ? searchInput.value.toLowerCase() : "";
        let visibleCount = 0;

        document.querySelectorAll('.order-item').forEach(card => {
            let s = card.getAttribute('data-status');
            let t = card.getAttribute('data-time');
            let text = card.textContent.toLowerCase();

            let show = (statusList.length === 0 || statusList.includes(s)) && (timeList.length === 0 || timeList.includes(t)) && (text.includes(search));

            if (show) {
                card.style.setProperty('display', 'flex', 'important');
                visibleCount++;
            } else {
                card.style.setProperty('display', 'none', 'important');
            }

            let noMsg = document.getElementById('no-orders-found');
            if (visibleCount === 0) {
                noMsg.style.display = 'block';
            } else {
                noMsg.style.display = 'none';
            }
        })
    }

    function cancelOrder(orderId) {
        if (confirm("Are you sure you want to cancel this order?")) {
            let form = new FormData();
            form.append('action', 'cancel_order');
            form.append('order_id', orderId);

            fetch('partials/_handel_order.php', {
                    method: 'POST',
                    body: form
                })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        showMyAlert("Order Cancelled Successfully");
                        location.reload()
                    }
                })
                .catch(error => console.log(error))
        }
    }
</script>

<?php include 'partials/_footer.php'; ?>