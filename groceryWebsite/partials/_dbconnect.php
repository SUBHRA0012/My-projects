<?php
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'grocery';

    $conn = mysqli_connect($server, $username, $password, $database);
    if(!$conn){
        echo "connect unsuccessfull", mysqli_connect_errno();
    }
?>