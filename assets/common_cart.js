console.log('common_cart js loaded with Toggle Feature');

document.addEventListener('click', function(e) {
    
    // when clicked to add to cart button
    let btn = e.target.closest('.global-add-to-cart, .global-remove-from-cart');
    if (btn) {
        let productId = btn.getAttribute('data-id');
        let isAddId = btn.classList.contains('global-add-to-cart');

        if(isAddId){
            //no login if no true
            if(typeof isLoggedIn == 'undefined' || isLoggedIn !== 'true'){
                let loginOverlay = document.getElementById('loginOverlay');
                if(loginOverlay){
                    loginOverlay.style.display = 'flex';
                }else{
                    showMyAlert('please login first')
                }
                return;
            }
        }
        let form = new FormData();
        form.append(isAddId ? 'add_id' : 'remove_id', productId);

        fetch('partials/_handel_cart.php', {
            method: 'POST',
            body: form
        })
        .then(response => response.text())
        .then(data => {

            if(data.trim() === "out_of_stock"){
                showMyAlert("Sorry! Not enough stock available.");
                return;
            }


            // Navbar update
            let cartCountEl = document.getElementById('cart-count');
            if(cartCountEl) cartCountEl.innerText = data;
            // button looks changed
            if(isAddId){
                btn.className = 'btn btn-danger w-100 global-remove-from-cart';
                btn.innerText = 'Remove';
                showMyAlert('Item add to cart');
            }else{
                btn.className = 'btn btn-success w-100 global-add-to-cart';
                btn.innerText = 'Add to Cart';
                showMyAlert('Item removed from cart');
            }
            
        })
        .catch(error => console.log('Error:', error));
    }
});

function showMyAlert(text) {
    let box = document.getElementById('custom-alert');
    if(box) {
        box.classList.replace('bg-success', 'bg-danger');
        if(text === 'Item add to cart' || text === 'Review Submitted Successfully' || text.trim() === 'message send'){
            box.classList.replace('bg-danger', 'bg-success');
        }
        box.innerText = text;           
        box.classList.remove('d-none'); 
        setTimeout(() => {
            box.classList.add('d-none'); 
        }, 3000);
    }
}