<?php
session_start();
include '_dbconnect.php';

if(isset($_POST['msg_action']) && $_POST['msg_action'] == 'msg_send'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $result = mysqli_query($conn, "INSERT INTO message_customer 
    (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')");
    if($result){
        echo 'message send';
    }else{
        echo 'unable to send';
    }
}else{
    echo 'something went wrong!';
}
?>
		