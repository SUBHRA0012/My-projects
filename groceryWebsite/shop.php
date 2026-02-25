<?php include 'partials/_navbar.php'?>

<div style="min-height: 80vh; background-color: #f8f9fa;">
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-success">Home</a></li>
                <li class="breadcrumb-item"><a href="shop.php" class="text-decoration-none text-success">Products</a></li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark m-0">Our Products</h3>
            
            <button class="btn btn-success d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar">
                <i class="bi bi-funnel"></i> Filters
            </button>
        </div>

        <div class="shop-layout d-flex align-items-start">
            <aside class="sidebar-filter offcanvas-md offcanvas-start bg-white" tabindex="-1" id="filterSidebar" style="width: 280px;">
                
                <div class="offcanvas-header d-md-none border-bottom">
                    <h5 class="offcanvas-title fw-bold">Filters</h5>
                    <button type="button" data-bs-target="#filterSidebar" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body flex-column p-md-0 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="d-none d-md-block m-0">Filters</h4>
                        <button id="clear-filter" class="btn btn-outline-danger btn-sm rounded-pill px-3">Clear</button>
                    </div>
                    
                    <div class="filter-box mb-4">
                        <p class="fw-bold text-secondary mb-2">Price Range</p>
                        <div class="filter-checkBox">
                            <label><input type="checkbox" class="price-check" value="0-20"> Under ₹20 </label>
                            <label><input type="checkbox" class="price-check" value="21-50"> ₹21 - ₹50</label>
                            <label><input type="checkbox" class="price-check" value="51-100"> ₹51 - ₹100</label>
                        </div>
                    </div>

                    <hr class="text-muted">
                    
                    <div id="dynamic-sidebar">
                    </div>
                </div>
            </aside>

            <div id="filtered" class="flex-grow-1">
                <div class="category-scroll-wrapper mb-4 sticky-top">
                    <section class="catagory-filter">
                        <button class="active" value="all">All</button>
                        <?php
                        $catagoryQ = "SELECT * FROM `categories`";
                        $catagoryRes = mysqli_query($conn, $catagoryQ);
                        while ($row = mysqli_fetch_assoc($catagoryRes)) {
                            echo '<button value="' . $row['id'] . '">' . $row['category_name'] . '</button>';
                        }
                        ?>
                    </section>
                </div>

                <div id="product-list">
                    </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/shop.js"></script>
<?php include 'partials/_footer.php' ?>