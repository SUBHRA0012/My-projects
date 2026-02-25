<?php require "partials/_dbconnect.php" ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <?php include "partials/_navbar.php"; ?>


    <div class="container" style="max-width:1000px; min-height: 567px;">
        <h1 class="my-3">Search result for: "<em><?php echo $_GET["search"] ?>"</em> </h1>
        <?php
            $word = $_GET["search"];
            $sql = "SELECT * FROM `catagory` WHERE MATCH(catagory_title, catagory_desc) against ('$word');";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo '
                        <div class="row ">
                            <h4><a href="threadlist.php?catid='.$row["catagory_id"].'" class="text-decoration-none text-dark">'.$row["catagory_title"].'</a></h4>
                            <p class="text-success">'.substr($row["catagory_desc"],0,200).'</p>
                        </div>
                    
                    ';

                }
            }else{
                echo '
                        <div class="alert alert-secondary my-5" role="alert">
                            <h4 class="alert-heading">Your search did not match any documents</h4>
                            <hr>
                            <p>Search tips
                            <ul>
                                <li>Make sure all words are spelled correctly</li>
                                <li>Try different or more general words</li>
                                <li>Try fewer words</li>
                            </ul>
                        </div>
                
                ';  
            }
        
        ?>




    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>
<?php include "partials/_footer.php"; ?>

</html>