<?php
session_start();
include '../partials/_dbconnect.php';
$login_error = false;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $admin = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `admin` WHERE `admin_name`='$admin' AND `password`='$password'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1){
        $_SESSION['admin_loggedin'] = true;
        $_SESSION['admin_name'] = $admin;
        header('location: index.php');
        exit;
    }else{
        $login_error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - PureGrocery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    
    <style>
        body { 
            background-color: #f4f6f9; 
        }
        .login-card { 
            border-radius: 15px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
            border: none; 
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh; margin: 0;">

    <div class="container" style="max-width: 400px;">
        <div class="card login-card p-4">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold text-success"><i class="bi bi-cart4"></i>PureGrocery</h3>
                <p class="text-muted mb-0">Admin Control Panel</p>
            </div>
            <?php
            if($login_error){
                echo '<div class="alert alert-danger py-2 text-center">'.$login_error.'</div>';
            }
            ?>

            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">USERNAME</label>
                    <input type="text" class="form-control" name="username" required placeholder="Enter username">
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold small text-muted">PASSWORD</label>
                    <input type="password" class="form-control" name="password" required placeholder="Enter password">
                </div>
                
                <button type="submit" class="btn btn-success w-100 fw-bold py-2">Login</button>
            </form>
            
            <div class="text-center mt-4">
                <a href="../index.php" class="text-decoration-none small text-muted">
                    <i class="bi bi-arrow-left"></i> Back to Website
                </a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>