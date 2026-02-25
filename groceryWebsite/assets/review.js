console.log('review js');

function loadReviews() {
    let listDiv = document.getElementById('review-list');
    if(listDiv){
        fetch('partials/_fetch_reviews.php?product_id=' + productId)
        .then(response => response.text())
        .then(data => {
            listDiv.innerHTML = data;
        })
    }
}

const reviewForm = document.getElementById('reviewForm');

if(reviewForm){
    reviewForm.addEventListener('submit', (e) => {
        e.preventDefault();


        let form = new FormData(e.target);
        fetch('partials/_handel_review.php', {
            method: 'POST',
            body: form
        })
        .then(response => response.json())
        .then(data => {
            if(data.status == 'success'){
                showMyAlert('Review Submitted Successfully');
                e.target.reset();
                document.querySelectorAll('.btn-check').forEach(el => el.checked = false);
                loadReviews();
            }else{
                showMyAlert(data.message || 'Error submitting review');
            }
        })
        .catch(error => console.log(error)
        )
    });
}

loadReviews();