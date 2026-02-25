<?php
session_start();
include '_dbconnect.php';

if(!isset($_SESSION['user_id'])){
    exit();
}

$user_id = $_SESSION['user_id'];
if($_POST['action'] && $_POST['action'] == 'place_order'){
    
    $address_id = $_SESSION['active_address_id'];
    $payment_method = $_POST['payment_method'];
    // ORD- (4) + Random Mixed (12) = Total 16 Chars
    $order_ref_id = "ORD-" . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 12);

    $sql = "SELECT SUM(c.qty * p.price) as total FROM carts c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_amount = $row['total'];

    if($total_amount > 0){
        $order_sql = "INSERT INTO `orders` (`user_id`, `address_id`, `total_amount`, `payment_method`, `order_ref_id`) 
                      VALUES ('$user_id', '$address_id', '$total_amount', '$payment_method', '$order_ref_id')";

        if(mysqli_query($conn, $order_sql)){
            $order_id = mysqli_insert_id($conn); //returns order id
            //populate table of order_item colums with the help of carts and products table colums
            $item_sql = "INSERT INTO `order_items` (`order_id`, `product_id`, `qty`, `price`)
                         SELECT '$order_id', c.product_id, c.qty, p.price 
                         FROM carts c 
                         JOIN products p ON c.product_id = p.id 
                         WHERE c.user_id = '$user_id'";
            mysqli_query($conn, $item_sql);

            //sending invoice to customer after order
            $sql_user = "SELECT `email` FROM `userbase` WHERE `user_id` = '$user_id'";
            $res_user = mysqli_query($conn, $sql_user);
            if($row_user = mysqli_fetch_assoc($res_user)){
                $customer_email = $row_user['email'];
            }
            
            // =======================
            // PHPMailer Email Logic
            // =======================
            
            require 'PHPMailer/Exception.php';
            require 'PHPMailer/PHPMailer.php';
            require 'PHPMailer/SMTP.php';

            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

            try{
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'billubiraj@gmail.com';
                $mail->Password = 'vxlvxqvhxbzqnrjc';
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('billubiraj@gmail.com', 'PureGrocery');
                $mail->addAddress($customer_email);
                $mail->isHTML(true);
                $mail->Subject = 'Order Successful - ' .$order_ref_id;

                $mail->Body = "
                    <div style='font-family: sans-serif; padding: 20px; background: #f9f9f9;'>
                        <h2 style='color: #198754;'>Order Placed Successfully!</h2>
                        <p>Hi,</p>
                        <p>Your order <b>#$order_ref_id</b> has been confirmed.</p>
                        <p><b>Total Amount:</b> ₹$total_amount</p>
                        <br>
                        <a href='http://localhost/grocerywebsite/partials/_invoice.php?id=$order_id' 
                           style='background: #198754; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>
                           View Invoice
                        </a>
                        <br><br>
                        <p>Thank you,<br><b>PureGrocery Team</b></p>
                    </div>
                ";
                $mail->send();
            }catch(Exception $e){
                echo "no mail send: {$mail->ErrorInfo}";
            }
            //empty the cart 
            mysqli_query($conn, "DELETE FROM `carts` WHERE `user_id` = '$user_id'");

            echo "success";
        }else{
            echo "Database Error";
        }
    }else{
        echo "Cart is Empty";
    }
}

if($_POST['action'] && $_POST['action'] == 'cancel_order'){
    $order_id = $_POST['order_id'];
    $check_sql = "SELECT order_status FROM `orders` WHERE `order_id` = '$order_id' AND `user_id` = '$user_id'";
    $check_res = mysqli_query($conn, $check_sql);

    if(mysqli_num_rows($check_res) > 0){
        $row = mysqli_fetch_assoc($check_res);
        $status = $row['order_status'];
        if($status != 'Delivered' && $status != 'Cancelled'){
            $updateSql = "UPDATE `orders` SET `order_status` = 'Cancelled' WHERE `order_id` = '$order_id'";
            if(mysqli_query($conn, $updateSql)){
                echo "success";
            }else{
                echo "Database Error";
            }
        }
    }
}


?>