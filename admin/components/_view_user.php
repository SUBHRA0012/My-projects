<?php
session_start();
include '../../partials/_dbconnect.php';
if (!isset($_SESSION['admin_loggedin']) || !$_SESSION['admin_loggedin']) exit;

if (isset($_POST['action']) && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];

    //change block to unblock
    if($action == 'toggle_status'){
        $status = $_POST['data_status'];
        $new_status = $status == 'active' ? 'blocked' : 'active';
        $query = "UPDATE userbase SET status = '$new_status' WHERE user_id = '$user_id'";
        if(mysqli_query($conn, $query)) echo 'success';
        exit;
    }

    //view the address
    if ($action == 'view') {
        $sql = "SELECT * FROM `user_address` WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '
                <div class="p-2">
                    <h6 class="text-primary border-bottom pb-2 mb-3">
                        <i class="bi bi-geo-alt-fill me-2"></i>Saved Addresses
                    </h6>

                    <div class="table-responsive shadow-sm rounded">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 20%;">Name</th>
                                    <th style="width: 15%;">Phone</th>
                                    <th class="text-start" style="width: 45%;">Full Address</th>
                                    <th style="width: 15%;">Type</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                ';

            $sno = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $name = $row['name'];
                $phone = $row['phone'];
                $pincode = $row['pincode'];
                $locality = $row['locality'] ? $row['locality'] : '';
                $address_line1 = $row['address_line1'];
                $state = $row['state'];
                $address_type = $row['address_type'];
                $created_at = $row['created_at'];
                echo '
                    <tr>
                        <td>' . $sno . '</td>
                        <td class="fw-bold text-dark">' . $name . '</td>
                        <td>' . $phone . '</td>
                        <td class="text-start">
                            <span class="d-block text-dark">' . $address_line1 . ' (' . $locality . ')</span>
                            <span class="text-muted small">' . $state . ' - ' . $pincode . '</span>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark px-3 rounded-pill">' . $address_type . '</span>
                        </td>
                    </tr>
                ';
                    $sno++;
            }

            echo '
                        </tbody>
                    </table>
                </div>
            </div>';
        } else {
            echo '
            <div class="text-center py-4">
                <i class="fas fa-box-open text-muted fs-1 mb-3"></i>
                <p class="text-danger">No items found for this order!</p>
            </div>';
        }
        exit;
    }
}
