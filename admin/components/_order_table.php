<?php
session_start();
include '../../partials/_dbconnect.php';
if(!isset($_SESSION['admin_loggedin']) || !$_SESSION['admin_loggedin']){
    exit;
}

$sql = "SELECT orders.*, user_address.name, user_address.phone FROM orders JOIN user_address 
ON orders.address_id = user_address.id ORDER BY orders.dt DESC";
$result = mysqli_query($conn, $sql);

if($result){
    while($row = mysqli_fetch_assoc($result)){
        $order_id = $row['order_id'];
        $user_id = $row['user_id'] ;
        $name = $row['name'];
        $address_id = $row['address_id'];
        $total_amount = $row['total_amount'];
        $payment_method = $row['payment_method'];
        $payment_status = $row['payment_status'];
        $order_status = $row['order_status'];
        $order_ref_id = $row['order_ref_id'];
        $dt = date('d M Y', strtotime($row['dt']));
        $phone = $row['phone'];
        $statusValue = ['Placed', 'Shipped', 'Delivered', 'Cancelled'];
        $select_options = '';

        foreach($statusValue as $options){
            $is_select = $order_status == $options ? "selected" : "";
            $select_options .= '<option value="'.$options.'" '.$is_select.'>'.$options.'</option>';
        }
        $is_disabled = ($order_status == 'Cancelled' || $order_status == 'Delivered') ? 'disabled' : '';
        $select_class = $order_status == 'Cancelled' ? 'text-danger border-danger' : 
        ($order_status == 'Delivered' ? 'text-success border-success' : '');

        echo '
        <tr>
            <td><strong>#'.$order_ref_id.'</strong></td>
            <td>'.$name.'<br><small class="text-muted">'.$phone.'</small></td>
            <td>'.$dt.'</td>
            <td>₹'.$total_amount.'</td>
            <td>
                <select class="form-select form-select-sm status-dropdown '.$select_class.'" data-order-id="'.$order_id.'" '.$is_disabled.'>
                    '.$select_options.'
               </select>
            </td>
            <td class="text-center">
                <button class="btn btn-success btn-sm view-btn" data-bs-toggle="modal" data-bs-target="#viewOrderModal" data-order-id="'.$order_id.'">
                    View Details
                </button>
            </td>
        </tr>
        ';
    }
}else{
    echo "failed";
}
?>