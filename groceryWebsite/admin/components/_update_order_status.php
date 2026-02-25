<?php
session_start();
include '../../partials/_dbconnect.php';

if(!isset($_SESSION['admin_loggedin']) || !$_SESSION['admin_loggedin']){
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $order_id = $_POST['status_id'];
    $order_status = $_POST['new_status'];
    $sql = "UPDATE `orders` SET `order_status` = '$order_status' WHERE `orders`.`order_id` = '$order_id'";
    if(mysqli_query($conn, $sql)){
        echo "updated";
    }else{
        echo "update failed";
    }
}
?>