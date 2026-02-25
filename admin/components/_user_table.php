<?php
session_start();
include '../../partials/_dbconnect.php';
if(!isset($_SESSION['admin_loggedin']) || !$_SESSION['admin_loggedin']) exit;


$sql = "SELECT userbase.user_id, userbase.username, userbase.email, userbase.phone, 
userbase.created_date, userbase.status, COUNT(orders.order_id) AS total_orders FROM userbase LEFT 
JOIN orders ON userbase.user_id = orders.user_id GROUP BY userbase.user_id;";

$result = mysqli_query($conn, $sql);
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $email = $row['email'];
        $phone = $row['phone'];
        $date = date('d M Y', strtotime($row['created_date']));
        $total_orders = $row['total_orders'];
        $status = $row['status'];
        $btn_text = $status == 'active' ? '<i class="bi bi-unlock"></i>' : '<i class="bi bi-lock"></i>';
        $bg = $status == 'active' ? 'success' : 'danger';
        echo '
                <tr>
                    <td>'.$user_id.'</td>
                    <td>
                        <span class="fw-bold d-block text-dark">'.$username.'</span>
                        <span class="small text-muted">'.$email.'</span>
                    </td>
                    <td>'.$phone.'</td>
                    <td>'.$date.'</td>
                    <td class="text-center">
                        <span class="badge bg-info text-dark rounded-pill px-3">'.$total_orders.'</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-'.$bg.'">'.$status.'</span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary view-btn" data-user-id="'.$user_id.'" data-bs-target="#viewUserModal" data-bs-toggle="modal">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                        <button class="btn btn-sm btn-'.$bg.' block-btn" data-user-id="'.$user_id.'" data-status="'.$status.'">
                            '.$btn_text.'
                        </button>
                    </td>
                </tr>
        ';
    }
}else{
    echo "error";
}
?>