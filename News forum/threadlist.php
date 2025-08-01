<?php require "partials/_dbconnect.php"; ?>
<?php ob_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thread</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <?php include "partials/_navbar.php"; ?>

    <?php
        $id = $_GET["catid"];
        $sql = "SELECT * FROM `catagory` WHERE catagory_id = $id;";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $cat_title = $row['catagory_title'];
            $cat_desc = $row['catagory_desc'];
            $cat_time = $row['created'];
            $cat_imgs = $row["imgs"];
            $timestamp = strtotime($cat_time);
            $formattedDate = date("d M y", $timestamp);
            $formattedTime = date("h:i A", $timestamp);

                echo '<div class="container my-4" style="max-width: 1200px;">
                <div class="alert alert-outline-success" style="min-height: 712px;">
                    <h4 class="text text-success ps-5 ms-5 my-3">' . $cat_title . '</h4>
                    <p class="text ms-5 ps-5 text-success">' . $formattedDate . ' ' . $formattedTime . '</p>
                    <hr>
                    <div class="container">
                        <img src="partials/imgs/' . $cat_imgs . '" class="mx-auto d-block" alt="..." style="height: 360px;width: auto;">
                        <br>
                        <hr>
                        <p>' . $cat_desc . '</p>
                    </div>
                </div>
            </div>';
        } 
    ?>

    <div class="container">
        <?php
        // Pagination setup for parent threads
        $limit = 5;
        if (isset($_GET['page'])) {
            $page = (int)$_GET['page'];
        } 
        else {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;

        // Total threads count
        $total_sql = "SELECT COUNT(*) AS total FROM `threads` WHERE thread_cat_id = $id;";
        $total_result = mysqli_query($conn, $total_sql);
        $total_threads = mysqli_fetch_assoc($total_result)['total'];
        $total_pages = ceil($total_threads / $limit);

        // Fetch current page's threads
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id ORDER BY thread_id DESC LIMIT $limit OFFSET $offset;";
        $result = mysqli_query($conn, $sql);
        $tbl = mysqli_num_rows($result);

        if ($tbl >= 1) {
            echo '<h2 class="text text-success">Public reactions</h2>';

            while ($row = mysqli_fetch_assoc($result)) {
                $thread_desc = $row["thread_desc"];
                $thread_id = $row["thread_id"];
                $thread_user_id = $row["thread_user_id"];
                $sql2 = "SELECT name_user FROM `signup` WHERE `sno` = '$thread_user_id';";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $when = $row["date_post"];
                include_once "partials/_time.php";
                $timm = timeAgoFromDateTime($when);

                echo '<div class="d-flex align-items-start my-4">
                    <div class="flex-shrink-0">
                        <img src="partials/logo.png" width="54px" alt="...">
                    </div>';

                $uniqueId = 'reply' . $thread_id;
                echo '<div class="flex-grow-1 ms-3">
                    <h6 class="mb-0">' . $row2["name_user"] . '</h6>' . $timm . '
                    <br>

                    <!-- Thread Description and Button side-by-side -->
                    <div class="d-flex align-items-center mt-1">
                        <a href="thread.php?threadid=' . $thread_id . '" class="text-decoration-none text-success me-3">
                            ' . $thread_desc . '
                        </a>
                        
                        <!-- Show Replies Button -->
                        <a class="btn btn-sm btn-outline-success" data-bs-toggle="collapse" href="#' . $uniqueId . '" role="button" aria-expanded="false" aria-controls="' . $uniqueId . '">
                            Show Replies
                        </a>
                    </div>
                    <div class="collapse mt-2" id="' . $uniqueId . '">
                        <div class="card card-body" style="border: none">';
                            $co_sql = "SELECT * FROM `comments` WHERE `thread_id` = $thread_id ORDER BY comment_id DESC;";
                            $co_result = mysqli_query($conn, $co_sql);
                            if(mysqli_num_rows($co_result) > 0) {
                                while ($co_row = mysqli_fetch_assoc($co_result)) {
                                    $by = $co_row["comment_by"];
                                    $sql2 = "SELECT name_user FROM `signup` WHERE `sno` = '$by';";
                                    $result2 = mysqli_query($conn, $sql2);
                                    $row2 = mysqli_fetch_assoc($result2);
                                    $reply = $co_row["comment_desc"];
                                    echo '<p class="mb-0"><strong class="text-primary">' . $row2["name_user"] . ':</strong> ' . $reply . '</p><hr>';
                                }
                            } else {
                                echo '<p>No replies found</p>';
                            }
                        echo '</div>
                    </div>
                </div>
            </div>';
            }

            // Thread pagination
            echo '<nav><ul class="pagination justify-content-center">';
            if ($page > 1) {
                echo 
                '<li class="page-item">
                    <a class="btn btn-success me-2" href="?catid=' . $id . '&page=' . ($page - 1) . '">Previous</a>
                </li>';
            }
            else{
                echo 
                '<li class="page-item">
                        <span class="btn btn-secondary disabled me-2">Previous</span>
                </li>';
            }
            
            if ($page < $total_pages) {
                echo 
                '<li class="page-item">
                    <a class="btn btn-success me-2" href="?catid=' . $id . '&page=' . ($page + 1) . '">Next</a>
                </li>';
            }
            else{
                echo 
                '<li class="page-item">
                    <span class="btn btn-secondary disabled me-2">Next</span>
                </li>';
            }
            echo '</ul></nav>';

            // Comment box or login message
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
                require "partials/_yescomment.php";
            } else {
                echo '
                <div class="alert alert-info my-5" role="alert">
                    <h4 class="alert-heading">Want to comment?</h4>
                    <p>Login to comment</p>
                </div>';
            }

        } else {
            echo '<h2>No comments yet</h2>';
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
                include 'partials/_nocomment.php';
            } else {
                echo '
                <div class="alert alert-info my-5" role="alert">
                    <h4 class="alert-heading">Want to comment?</h4>
                    <p>Login to comment</p>
                </div>';
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>
<footer><?php include "partials/_footer.php"; ?></footer>
<?php ob_end_flush(); ?>
</html>
