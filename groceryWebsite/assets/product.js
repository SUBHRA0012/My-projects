// console.log('js of product.js');

//image changing in product page
let productImages = document.querySelectorAll('#product-images img');
let mainImg = document.getElementById('mainImage');
if (mainImg) {
    mainImg.setAttribute('data-zoom', mainImg.src)
    productImages.forEach(imgs => {
        imgs.addEventListener('click', (e) => {
            productImages.forEach(removeClass => removeClass.classList.remove('active'))
            e.target.classList.add('active');
            mainImg.src = e.target.src;
            mainImg.setAttribute('data-zoom', mainImg.src)
        })
    })
}
//image zoom pan
let zoomPan = document.getElementById('zoomResult');
if (zoomPan) {
    new Drift(mainImg, {
        paneContainer: zoomPan,
        inlinePane: false,
        hoverBoundingBox: true,
        zoomFactor: 3,

        onShow: function () {
            zoomPan.style.display = 'block';
        },

        onHide: function () {
            zoomPan.style.display = 'none';
        }

    });
}

//add to cart count
let addToCartBtn = document.getElementById('add-cart');
// console.log(addToCartBtn.classList);
// let cartCount = document.getElementById('cart-count');
// console.log(cartCount.innerText);


if (addToCartBtn) {
    addToCartBtn.addEventListener('click', (e) => {
        if(typeof isLoggedIn == 'undefined' || isLoggedIn !== 'true'){
                let loginOverlay = document.getElementById('loginOverlay');
                if(loginOverlay){
                    loginOverlay.style.display = 'flex';
                }else{
                    showMyAlert('please login first')
                }
                return;
        }
        let dataForm = new FormData();
        dataForm.append('add_id', productId);
        
        // console.log('product id', productId);
        
        let productQty = document.getElementById('productQty');
        if(productQty) dataForm.append('qty', productQty.value);
        // console.log('product quantity:', productQty.value);
        
        fetch('partials/_handel_cart.php', {
            method: 'POST',
            body: dataForm
        })
            .then(response => response.text())
            .then(data => {
                if(data.trim() === "out_of_stock"){
                    showMyAlert("Sorry! Not enough stock available.");
                    return; 
                }
                let qtyDiv = document.getElementById('qtyDiv');
                document.getElementById('cart-count').innerText = data;
                showMyAlert('Item add to cart');
                console.log(data);
                addToCartBtn.classList.add('visually-hidden');
                removeCartBtn.classList.remove('visually-hidden')
                qtyDiv.classList.add('pe-none', 'opacity-50');
            })
            .catch(error => console.log('error is', error)

            )
    })
}

let removeCartBtn = document.getElementById('remove-cart');
if (removeCartBtn) {
    removeCartBtn.addEventListener('click', () => {

        let dataForm = new FormData();
        dataForm.append('remove_id', productId);
        fetch('partials/_handel_cart.php', {
            method: 'POST',
            body: dataForm
        })
            .then(response => response.text())
            .then(data => {
                document.getElementById('cart-count').innerText = data;
                // console.log('cart remove', data);
                showMyAlert('Item removed from the cart')
                removeCartBtn.classList.add('visually-hidden');
                addToCartBtn.classList.remove('visually-hidden');
                let qtyDiv = document.getElementById('qtyDiv');
                qtyDiv.classList.remove('pe-none', 'opacity-50');

            })
            .catch(error => console.log('error is', error)
            )
    })
}




