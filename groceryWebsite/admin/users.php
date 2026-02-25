<?php
session_start();
include '../partials/_dbconnect.php';
include 'components/_sidebar.php';
?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 text-gray-800">Users Management</h2>
    </div>

    <div class="row mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="input-group shadow-sm">
                <input type="text" id="searchUserInput" class="form-control" placeholder="Search by Name, Email or Phone...">
                <select id="statusUserFilter" class="form-select bg-light" style="max-width: 150px; cursor: pointer;">
                    <option value="All">All Status</option>
                    <option value="active">Active</option>
                    <option value="blocked">Blocked</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">All Users List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="usersTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>User ID</th>
                            <th>Name & Email</th>
                            <th>Phone</th>
                            <th>Registered Date</th>
                            <th class="text-center">Total Orders</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="viewUserModalLabel">User Profile & History</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="userDetailsContent">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="javascripts/users.js"></script>
<?php include 'components/_footer.php' ?>