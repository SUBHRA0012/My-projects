<?php
session_start();
include '_dbconnect.php';
header('Content-Type: application/json');
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    echo json_encode(["status" => "error"]);
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $review_text = mysqli_real_escape_string($conn, $_POST['review_text']);

    //only one time review
    $unique_check = "SELECT * FROM `reviews` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
    $check_res = mysqli_query($conn, $unique_check);
    if(mysqli_num_rows($check_res) > 0){
        echo json_encode(["status" => "error", "message" => "You have already reviewd this product."]);
        exit;
    }
    $check_deliver = "SELECT orders.order_id  FROM `orders` JOIN `order_items` 
                    ON orders.order_id = order_items.order_id WHERE orders.user_id = '$user_id' 
                    AND order_items.product_id = '$product_id' AND orders.order_status = 'Delivered'";
    $deliver_res = mysqli_query($conn, $check_deliver);
    if(mysqli_num_rows($deliver_res) > 0){
        $sql = "INSERT INTO `reviews` (`product_id`, `user_id`, `rating`, `review_text`) VALUES ('$product_id', '$user_id', '$rating', '$review_text')";
        if(mysqli_query($conn, $sql)){
            echo json_encode(["status" => "success"]);
        }else{
            echo json_encode(["status" => "error"]);
            }
    }else{
        echo json_encode(["status" => "error"]);
    }
}
?>