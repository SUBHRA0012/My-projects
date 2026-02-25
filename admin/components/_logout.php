<?php
session_start();
if(isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin']){
    unset($_SESSION['admin_loggedin']);
    unset($_SESSION['admin_name']);
    header('location: ../login.php');
    exit;
}
?>