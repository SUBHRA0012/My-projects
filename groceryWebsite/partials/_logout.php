<?php
session_start();
if($_SESSION['loggedin'] && isset($_SESSION['user_id'])){
    unset($_SESSION['loggedin']);
    unset($_SESSION['user_id']);
    
    header('location: ../index.php?logout=true');
    exit;
}
?>