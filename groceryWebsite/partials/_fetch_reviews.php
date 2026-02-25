<?php
include '_dbconnect.php';

if(isset($_GET['product_id'])){
    $product_id = $_GET['product_id'];

    $sql = "SELECT reviews.*, userbase.username FROM `reviews` 
            JOIN `userbase` ON reviews.user_id = userbase.user_id WHERE reviews.product_id = '$product_id' 
            ORDER BY reviews.review_date DESC";

    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $username = htmlspecialchars($row['username']);
            $rating = $row['rating'];
            $review = htmlspecialchars($row['review_text']);
            $date = date("d M Y", strtotime($row['review_date']));

            $stars = "";
            for($i = 1; $i<=5; $i++){
                if($i <= $rating){
                    $stars .= '<i class="fas fa-star text-warning"></i>';
                    }else{
                        $stars .= '<i class="fas fa-star text-secondary"></i>';
                }
            }

            echo '
            <div class="review-item mb-3 pb-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">' . $username . '</h6>
                    <small class="text-muted">' . $date . '</small>
                </div>
                <div class="mb-2 text-warning" style="font-size: 0.9rem;">
                    ' . $stars . '
                </div>
                <p class="mb-0 text-secondary" style="font-size: 0.95rem;">
                    ' . $review . '
                </p>
            </div>';
        }
    }else{
        echo '<p class="text-center text-muted py-3">No reviews yet. Be the first to review!</p>';
    }
}
?>