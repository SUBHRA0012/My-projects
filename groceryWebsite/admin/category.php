<?php
session_start();
include '../partials/_dbconnect.php';

//===================
//Edit category name
//===================
if(isset($_POST['edit_category'])){
    $cat_id = $_POST['cat_id'];
    $cat_name = $_POST['category_name'];
    $resEdit = mysqli_query($conn, "UPDATE categories SET category_name = '$cat_name' WHERE id = '$cat_id'");
    header('location: category.php');
    exit;
}

//==================
//Add category name
//==================
if(isset($_POST['add_category'])){
    $catNme = $_POST['category_name'];
    $sqlAdd = mysqli_query($conn, "INSERT INTO categories (category_name) VALUES ('$catNme')");
    header('location: category.php');
    exit;
}
include 'components/_sidebar.php';
?>

<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold m-0 text-dark">Categories</h4>
                <button class="btn btn-sm btn-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Category
                </button>
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="ps-3 py-2" style="width: 60px;">ID</th>
                                    <th class="py-2">Category Name</th>
                                    <th class="py-2 text-end pe-3" style="width: 100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="categoryTableBody">
                                <?php
                                $result = mysqli_query($conn, "SELECT * FROM categories");
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_assoc($result)){
                                        $category_id = $row['id'];
                                        $category_name = $row['category_name'];
                                        echo '
                                        <tr>
                                            <td class="ps-3 text-secondary">'.$category_id.'</td>
                                            <td class="fw-semibold text-dark">'.$category_name.'</td>
                                            <td class="text-end pe-3">
                                                <button class="btn edit-btn btn-sm btn-outline-primary py-0 px-2" 
                                                data-bs-toggle="modal" data-bs-target="#editModal'.$category_id.'">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        
                                        <div class="modal fade" id="editModal'.$category_id.'" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header border-bottom-0 pb-0">
                                                        <h5 class="modal-title fw-bold">Edit Category</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="cat_id" value="'.$category_id.'">
                                                            <div class="mb-4 mt-2">
                                                                <label class="form-label fw-semibold text-muted small">Category Name</label>
                                                                <input type="text" name="category_name" class="form-control form-control-lg" value="'.$category_name.'" required>
                                                            </div>
                                                            <div class="text-end">
                                                                <button type="button" class="btn btn-light me-2 px-3" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" name="edit_category" class="btn btn-primary px-4">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        '; 
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="mb-4 mt-2">
                        <label class="form-label fw-semibold text-muted small">Category Name</label>
                        <input type="text" name="category_name" class="form-control form-control-lg" placeholder="e.g., Dairy" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-light me-2 px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_category" class="btn btn-success px-4">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'components/_footer.php'; ?>