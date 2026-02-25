<?php
include "_dbconnect.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["username"];
    $key = $_POST["password"];
    $sql = "SELECT * FROM `signup` WHERE `name_user` = '$name';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            $password = $row["user_pass"];
            $sno = $row["sno"];
            if (password_verify($key, $password)) {
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["user"] = $name;
                $_SESSION["sno"] = $sno;
                
                echo "Login successfully";
                header("location: /forum/index.php?log=true");
                
                
            } 
            else {
                echo "wrong userid or password";
                header("location: /forum/index.php?log=false");
            }
        }
    }
    else{
        header("location: /forum/index.php?log=false");
    }
    



}



?>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginModalLabel">Login here</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="/forum/partials/_login.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Enter username</label>
                            <input type="text" name="username" class="form-control" id="usernlog">
                            <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                        </div>
                        <div class="mb-3">
                            <label for="Passwordlog" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="Passwordlog">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>