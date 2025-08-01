<?php
include "_dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["form_type"]) && $_POST["form_type"] === "signup_form" ) {
    $uname = $_POST["username"];
    $pass = $_POST["password"];
    $cpass = $_POST["cpassword"];

    $execute = "SELECT * FROM `signup` WHERE `name_user`= '$uname';";
    $ex_res = mysqli_query($conn, $execute);

    if (mysqli_num_rows($ex_res) > 0) {
        echo "Username already exist";
    } else {
        if ($pass == $cpass) {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `signup` (`name_user`, `user_pass`, `date_create`) 
            VALUES ('$uname', '$hash', current_timestamp());";
            $result = mysqli_query($conn, $sql);

            if($result){
                header("location: /forum/index.php?sign=true");
                exit;
            }

        }else{
            $alart = "Password doesnot matched";
        }
    }
    header("location: /forum/index.php?sign=false&$alart");

}


?>

<!-- Signup Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="signupModalLabel">Signup here</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="/forum/partials/_signup.php" method="post">
                        <input type="hidden" name="form_type" value="signup_form">

                        <div class="mb-3">
                            <label for="username" class="form-label">Enter username</label>
                            <input type="text" class="form-control" id="usersign" name="username">
                            <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                        </div>
                        <div class="mb-3">
                            <label for="Passwordsign" class="form-label">Password</label>
                            <input type="password" class="form-control" id="Passwordsign" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="Passwordsign" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="Passwordsign" name="cpassword">
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