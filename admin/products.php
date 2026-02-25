<?php
session_start();
include '../partials/_dbconnect.php';
include 'components/_sidebar.php';
?>

<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-box-seam me-2"></i>Manage Products</h4>
        <button class="btn btn-success fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-lg me-1"></i> Add New Product
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="input-group shadow-sm">
                <input type="text" id="searchProductInput" class="form-control" placeholder="Search by Product, Category or Price...">

                <select id="categoryFilter" class="form-select bg-light" style="max-width: 150px; cursor: pointer;">
                    <option value="All">All Categories</option>
                    <?php
                    $sql_cat = "SELECT * FROM `categories`";
                    $res_cat = mysqli_query($conn, $sql_cat);
                    if (mysqli_num_rows($res_cat) > 0) {
                        while ($row_cat = mysqli_fetch_assoc($res_cat)) {
                            $category_name = $row_cat['category_name'];
                            $category_id = $row_cat['id'];
                            echo '
                            <option value="'.$category_name .'">'.$category_name .'</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT products.*, categories.category_name FROM `products` 
                    JOIN `categories` ON products.category_id = categories.id ORDER BY products.id DESC";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $image = $row['image'];
                            $product_name = $row['product_name'];
                            $category = $row['category_name'];
                            $price = $row['price'];
                            $stock = $row['stock'];
                            $unitWHat = $category == 'dairy' ? 'liter' : 'kg';
                            $old_price = $row['old_price'];
                            $id = $row['id'];

                            echo '
                            <tr id=' . $id . '>
                                <td>
                                    <img src="../partials/images/productImages/' . $image . '" alt="Product" class="rounded border" width="50" height="50" style="object-fit: cover;" onerror="this.src=\'https://placehold.co/50x50\'">
                                </td>
                                <td class="fw-bold text-dark">' . $product_name . '</td>
                                <td class="text-muted">' . $category . '</td>
                                <td class="fw-bold text-success">
                                 ₹' . $price . ' <span class="text-muted fw-normal small">/ ' . $unitWHat . '</span>';
                            if ($old_price > $price) {
                                echo ' <span class="text-muted text-decoration-line-through me-1 small">₹ ' . $old_price . '</span>';
                            }
                            echo '
                                </td>
                                <td><span class="badge bg-success bg-opacity-10 text-success px-2 py-1">' . $stock . ' ' . $unitWHat . '</span></td>
                                <td>
                                    <button class="btn edit-btn btn-sm btn-primary me-1" edit-id="' . $id . '"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn delete-btn btn-sm btn-danger" data-id="' . $id . '"><i class="bi bi-trash"></i></button>
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

<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-success text-white border-0">
                <h5 class="modal-title fw-bold" id="addProductModalLabel"><i class="bi bi-plus-circle me-2"></i>Add New Product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <!-- <form id="productForm" enctype="multipart/form-data"> -->
                <form id="productForm" action="components/_product_upload.php" method="POST" enctype="multipart/form-data">

                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="card border-0 shadow-sm p-3 mb-3">
                                <h6 class="fw-bold text-success mb-3 border-bottom pb-2">Basic Information</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted">Product Name</label>
                                        <input type="text" name="product_name" class="form-control" required placeholder="e.g. Mango - Fresh Mango">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted">Category</label>
                                        <select name="category_id" class="form-select" required>
                                            <option value="">Select Category</option>
                                            <?php
                                            $sql_cat = "SELECT * FROM `categories`";
                                            $res_cat = mysqli_query($conn, $sql_cat);
                                            if (mysqli_num_rows($res_cat) > 0) {
                                                while ($row_cat = mysqli_fetch_assoc($res_cat)) {
                                                    $category_name = $row_cat['category_name'];
                                                    $category_id = $row_cat['id'];
                                                    echo '
                                                    <option value="' . $category_id . '|' . $category_name . '">' . $category_name . '</option>
                                                    ';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold small text-muted">Price (₹)</label>
                                        <input type="number" step="0.01" name="price" class="form-control" required placeholder="150">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold small text-muted">Old Price (₹)</label>
                                        <input type="number" step="0.01" name="old_price" class="form-control" placeholder="Optional">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold small text-muted">Stock Quantity</label>
                                        <input type="number" name="stock" class="form-control" required placeholder="e.g. 50">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold small text-muted">Short Description</label>
                                        <textarea name="product_desc" class="form-control" rows="2" required placeholder="Write a short description..."></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold small text-muted">Nutritional Facts (Detail Description)</label>
                                        <textarea name="detail_desc" class="form-control" rows="3" placeholder="Write detailed nutritional facts and benefits..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="card border-0 shadow-sm p-3 h-100">
                                <h6 class="fw-bold text-success mb-3 border-bottom pb-2">Product Images</h6>

                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted">Main Image <span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control form-control-sm" accept="image/*" required>
                                </div>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label fw-bold small text-muted">Thumbnail 1</label>
                                        <input type="file" name="thumb_img1" class="form-control form-control-sm" accept="image/*" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold small text-muted">Thumbnail 2</label>
                                        <input type="file" name="thumb_img2" class="form-control form-control-sm" accept="image/*" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold small text-muted">Thumbnail 3</label>
                                        <input type="file" name="thumb_img3" class="form-control form-control-sm" accept="image/*" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold small text-muted">Thumbnail 4</label>
                                        <input type="file" name="thumb_img4" class="form-control form-control-sm" accept="image/*" required>
                                    </div>
                                </div>

                                <div class="alert alert-info mt-4 py-2 small border-0 mb-0 text-center">
                                    <i class="bi bi-info-circle me-1"></i> Recommended size: 800x800px (JPG, PNG).
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-light fw-bold px-4 me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_product" class="btn btn-success fw-bold px-5">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="javascripts/products.js"></script>
<?php include 'components/_footer.php'; ?>