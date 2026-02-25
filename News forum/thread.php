<?php 

require "partials/_dbconnect.php" ;
  $dekha = false;
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
  <?php 
  ob_start();
  include "partials/_navbar.php"; ?>
  <div class="container">
    <?php
    $t_id = $_GET["threadid"];

    $sql = "SELECT * FROM `threads` WHERE `thread_id` = $t_id;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
      $date_post = $row["date_post"];
      $thread_desc = $row["thread_desc"];
      $timestamp = strtotime($date_post);
      $thread_user_id = $row["thread_user_id"];
      $sql2 = "SELECT name_user FROM `signup` WHERE `sno` = '$thread_user_id';";
      $result2 = mysqli_query($conn, $sql2);
      $row2 = mysqli_fetch_assoc($result2);
      $row2["name_user"];

      $formattedDate = date("d M y", $timestamp); // 12 Jul 25
      $formattedTime = date("h:i A", $timestamp); //12:30 PM
      echo '
          <div class="alert alert-outline-success my-4" role="alert" style="max-width: 1200px;">
            <h4 class="alert-heading">' . $thread_desc. '</h4>
            <p>' . $formattedDate .' '.$formattedTime. '</p>
            <hr>
            <p class="mb-0">By: '.$row2["name_user"].'</p>
          </div>';
    }
    ?>
    <div class="container">
      <h2 class="text text-success">Replies</h2>
      <?php
        $query = "SELECT * FROM `comments` WHERE `thread_id`= $t_id;";
        $execute = mysqli_query($conn, $query);

        if(mysqli_num_rows($execute) > 0) {
          $dekha = true;
          while ($row1 = mysqli_fetch_assoc($execute)) {
            $comment_by = $row1["comment_by"];
            $date_time = $row1["date_time"];
            $comment_desc = $row1["comment_desc"];
            include_once "partials/_time.php";
            $timm = timeAgoFromDateTime($date_time);

            $sql3 = "SELECT name_user FROM `signup` WHERE `sno` = '$comment_by';";
            $result3 = mysqli_query($conn, $sql3);
            $row3 = mysqli_fetch_assoc($result3);
            $row3["name_user"];

            echo '
              <div class="d-flex align-items-start my-4">
                <div class="flex-shrink-0">
                    <img src="partials/logo.png" width="54px" alt="...">
                </div>
                <div class="flex-grow-1 ms-3"> 
                    <h6 class="mb-0">'.$row3["name_user"].'</h6>' .$timm .'
                    <br>
                    <a href="#" class="text-decoration-none text-success">' . $comment_desc . '</a>
                </div>
              </div>

            
            ';
          }
        }else{
          echo '<h2 class="display-6">No replies yet</h2>'; 
        }

      ?>
    </div>
    

  </div>
  <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      //$username = $_POST["username"];
      $comment = $_POST["comment"];
      $comment = str_replace("<","&lt", $comment);
      $comment = str_replace(">", "&gt", $comment); 
      $id_user = $_SESSION["sno"];
      $ssql = "INSERT INTO `comments` (`comment_desc`, `thread_id`, `comment_by`, `date_time`) 
      VALUES ('$comment', '$t_id', '$id_user', current_timestamp());";

      $rresult = mysqli_query($conn, $ssql);
      if ($rresult) {
        header("Location: thread.php?threadid=$t_id");
        
        exit;
      }

    }

  ?>

  <div class="container" style="min-height: 255px;">
    <div class="alert alert-info my-5" role="alert">
      <?php 
        if(!$dekha){
          echo '<h4 class="alert-heading">No Comments Yet</h4>
                <p>Be the first one comment down below</p>';
        }
        else{
          echo '<h4 class="alert-heading">Want to comment?</h4>
                <p>Comment down below</p>';
        }
      ?>
      <hr>
      
      <div class="container">
        <?php
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
          echo '
                <form action="thread.php?threadid=' . $t_id . '" method="post">
                  <div class="mb-3">
                    <label for="comment" class="form-label">Comment Down blow</label>
                    <textarea name="comment" class="form-control" id="comment" style="height: 125px;"></textarea>
                    <div id="commentHelp" class="form-text">Be respectful with your comment.</div>
                  </div>
                  <button type="submit" class="btn btn-success">Submit</button>
                </form>
          
          
          ';
        }
        else{
          echo "Login to comment";
        }
        ?>
      </div>

    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous"></script>
</body>
<?php include "partials/_footer.php";
ob_end_flush()
?>

</html>