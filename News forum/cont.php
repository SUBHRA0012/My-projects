<?php require "partials/_dbconnect.php" ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $email = $_POST['email'];
    $number = $_POST['number'];
    $query = $_POST['query'];

    $sql = "INSERT INTO `contact` (`email`, `phone_no`, `query`, `date`) VALUES ('$email', '$number', '$query', current_timestamp());";
    $result = mysqli_query($conn, $sql);

    if($result){
        header("location: cont.php");
        exit();
    }
}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <?php include "partials/_navbar.php"; ?>
    <div class="container my-3 py-5 " style="min-height: 79.3vh;">
        
        <form style="margin-left: 200px; margin-right: 200px;" action="cont.php" method="post">
            
            <h1 class="text-success">Contact us</h1>
            <hr>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="number" class="form-label">Phone no</label>
                <input type="contact" name="number" class="form-control" id="number">
            </div>

            <div class="mb-3">
                <label for="query" class="form-label">Type here</label>
                <textarea class="form-control" name="query" placeholder="Write something.."
                    style="height: 125px;"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
           
        </form>
        
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>
<?php include 'partials/_footer.php' ?>

</html>