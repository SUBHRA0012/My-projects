<?php
session_start();
include '_dbconnect.php';


/********************code for sign in*************************/
if (isset($_POST['submit_action'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email =  mysqli_real_escape_string($conn, $_POST['email']);
    $phone =  mysqli_real_escape_string($conn, $_POST['phone']);
    
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $existUser = "SELECT * FROM `userbase` WHERE `username` = '$username'";
    $resultUser = mysqli_query($conn, $existUser);

    if (mysqli_num_rows($resultUser) > 0) {
        echo "user_exist";
        exit();
    }

    
    $existEmail = "SELECT * FROM `userbase` WHERE `email` = '$email'";
    $resultEmail = mysqli_query($conn, $existEmail);

    if (mysqli_num_rows($resultEmail) > 0) {
        echo "email_exist";
        exit();
    }

    $existPhone = "SELECT * FROM `userbase` WHERE `phone` = '$phone'";
    $resultPhone = mysqli_query($conn, $existPhone);

    if (mysqli_num_rows($resultPhone) > 0) {
        echo "phone_exist";
        exit();
    }

    if ($password != $cpassword) {
        echo "password_mismatched";
        exit();
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO `userbase` (`username`, `email`, `phone`, `user_password`) VALUES ('$username', '$email', '$phone', '$hash')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "success_sign";
    } else {
        echo "error";
    }
    exit();
}




/*********************code for login***************/
if (isset($_POST['login_action'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM `userbase` WHERE `username` = '$username'";

    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['user_password'];
        if (password_verify($password, $storedPassword)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['user_id'];
            

            // $user_id = $row['user_id'];
            // $query = "SELECT * FROM `carts` WHERE `user_id` = '$user_id'";
            // $resultQry = mysqli_query($conn, $query);

            // while($cartRow = mysqli_fetch_assoc($resultQry)){
            //     $product_id = $cartRow['product_id'];
            //     $qty = $cartRow['qty'];

            //     $_SESSION['cart'][$product_id] = $qty;
            // }
            echo "success";
        } else {
            echo "wrong password";
        }
    } else {
        echo "wrong_user";
    }
    exit();
}
