<?php
session_start();
include '../partials/_dbconnect.php';
include 'components/_sidebar.php';
?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 text-gray-800">Orders Management</h2>
    </div>

    <div class="row mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="input-group shadow-sm">
                <input type="text" id="searchOrderInput" class="form-control" placeholder="Search by Order ID, Name or Phone...">

                <select id="statusFilter" class="form-select bg-light" style="max-width: 150px; cursor: pointer;">
                    <option value="All">All Status</option>
                    <option value="Placed">Placed</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">All Orders List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="ordersTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Date</th>
                            <th>Total Bill</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="orderTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="viewOrderModalLabel">Order Details / Invoice</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="orderDetailsContent">
                <!-- js content here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="printInvoiceBtn" target="_blank" class="btn btn-success">Print Invoice</a>
            </div>
        </div>
    </div>
</div>
<script src="javascripts/orders.js"></script>
<?php include 'components/_footer.php' ?>