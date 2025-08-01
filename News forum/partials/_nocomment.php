
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["form_type"]) && $_POST["form_type"] === "comment_form") {
        
        $comment = $_POST["comment"];
        $comment = str_replace("<","&lt", $comment);
        $comment = str_replace(">", "&gt", $comment); 
        $id_user = $_SESSION["sno"];
        $ssql = "INSERT INTO `threads` (`thread_desc`, `thread_cat_id`, `thread_user_id`, `date_post`) VALUES ('$comment', '$id', '$id_user', current_timestamp());";

        $rresult = mysqli_query($conn, $ssql);
        if ($rresult) {
            header("Location: threadlist.php?catid=$id");
            exit;
        }

    }

?>

<div class="container">
    <div class="alert alert-info my-5" role="alert">
        <h4 class="alert-heading">No Comments Yet</h4>
        <p>Be the first one comment down below</p>
        <hr>
        <div class="container">
            <form action="threadlist.php?catid=<?php echo $id; ?>" method="post">
                <input type="hidden" name="form_type" value="comment_form">
                <div class="mb-3">
                    <label for="comment" class="form-label">Comment Down blow</label>
                    <textarea name="comment" class="form-control" id="comment" style="height: 125px;"></textarea>
                    <div id="commentHelp" class="form-text">Be respectful with your comment.</div>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>


        </div>

    </div>
</div>