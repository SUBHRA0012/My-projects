console.log('cart js codes');

const loadCartData = () =>{
    let cartDiv = document.getElementById('dynamic-cart-content');

    let form = new FormData();
    form.append('fetch_cart_view', true);

    fetch('partials/_handel_cart.php', {
        method: 'POST',
        body: form
    })
    .then(response => response.text())
    .then(data => cartDiv.innerHTML = data)
    .catch(error => console.log('error is', error)
    )
}

document.addEventListener('click', (e) =>{
    let incBtn = e.target.closest('.cart-qty-inc');
    let decBtn = e.target.closest('.cart-qty-dec');
    let removeBtn = e.target.closest('.cart-remove-btn');

    if(incBtn || decBtn || removeBtn){
        let id, action, qtyToSend;
        
        if(removeBtn){
            id = removeBtn.getAttribute('data-id');
            action = 'remove';
            qtyToSend = 0;
        }else if(incBtn){
            let parent = incBtn.closest('.cart-qty-action');
            id = parent.getAttribute('data-id');
            let input = parent.querySelector('.qty-input');
            let currentVal = parseInt(input.value);
            if(currentVal >= 12){
                return;
            }
            action = 'update';
            qtyToSend = 1;
            // if(currentQty < 12) currentQty++;
        }else if(decBtn){
            let parent = decBtn.closest('.cart-qty-action');
            id = parent.getAttribute('data-id');
            let input = parent.querySelector('.qty-input');
            let currentVal = parseInt(input.value);
            if(currentVal <= 1) return;
            action = 'update';
            qtyToSend = -1;
            // if(currentQty > 1) currentQty--;
        }
    updateCartServer(id, action, qtyToSend);

    }
});


function updateCartServer(id, action, qty){
    let form = new FormData();

    if(action == 'remove'){
        form.append('remove_id', id);
    }else{
        form.append('add_id', id);
        form.append('qty', qty);
    }

    fetch('partials/_handel_cart.php', {
        method: 'POST',
        body: form
    })
    .then(response => response.text())
    .then(data =>{
        if(data.trim() === "out_of_stock"){
            showMyAlert("sorry ! stock limit reached");
        }else if(!isNaN(data)){
            let navCount = document.getElementById('cart-count');
            if (navCount) navCount.innerText = data;
            loadCartData();
            
        }
    })
}

//open popup and show the amount
const openCheckoutModal = (total, count) => {
    document.getElementById('checkout_total_items').innerText = count;
    document.getElementById('checkout_final_amount').innerText = total;
    openPopup('checkoutOverlay');
}

const placeOrder = (e) => {
    e.preventDefault();

    let form = new FormData(document.getElementById('placeOrderForm'));
    form.append('action', 'place_order');

    let btn = e.target.querySelector('button');
    let oldText = btn.innerHTML;
    btn.innerHTML = 'Processing...';
    btn.disabled = true;

    fetch('partials/_handel_order.php', {
        method: 'POST',
        body: form
    })
    .then(response => response.text())
    .then(data => {
        if(data.trim() === "success"){
            window.location.href = "partials/_order_success.php";
        }else{
            showMyAlert('Order Failed!' + data);
            btn.innerHTML = oldText;
            btn.disabled = false;
        }
    })
}


loadCartData();

