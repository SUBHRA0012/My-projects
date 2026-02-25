console.log('shop.php\'s javascript file');
let categoryBtn = document.querySelectorAll('.catagory-filter button');
let productList = document.getElementById('product-list');
let sidebarContainer = document.getElementById('dynamic-sidebar');
// console.log(categoryBtn);



//scrolling appear vanished effect
const scrollBox = document.getElementById('filtered')
// console.log(scrollBox);

scrollBox.addEventListener('scroll', () => {
    scrollBox.classList.add('scrolling');

    setTimeout(() => {
        scrollBox.classList.remove('scrolling');
    }, 700);
})




/****************Main Logic For Filteration Process************/
//take the category id from catagory buttons
categoryBtn.forEach(btn => {
    btn.addEventListener('click', () => {
        // console.log(btn.value);
        let categotyId = btn.value;

        // console.log(categotyId);

        fetchProduct(categotyId);

        categoryBtn.forEach(removeButton => removeButton.classList.remove('active'));
        btn.classList.add('active');

    });
}
);

//clear filter button making
let clearFilterBtn = document.getElementById('clear-filter');
clearFilterBtn.addEventListener('click', () => {
    fetchProduct('all')
    categoryBtn.forEach(removeButton => {
        removeButton.classList.remove('active');
        if (removeButton.value == 'all') {
            removeButton.classList.add('active');

        }
    });
    
    let allCheckBoxes = document.querySelectorAll('.price-check');
    allCheckBoxes.forEach(box => {
        box.checked = false; //remove tick
    });

})

//use the catagory id to fetch card content
function fetchProduct(catId) {
    fetch(`fetch_product.php?category_id=${catId}`)
        .then(response => response.json())
        .then(data => {
            // console.log('data is', data);

            productList.innerHTML = data.gridHtml;

            updateSidebar(data.sidebarData);

            applyFilterCheck()

        })
        .catch(error => console.log('Error', error)
        )
}

//sidebar list item populator
function updateSidebar(sidebarD) {
    let sidebarHtml = '';

    //using loop in sidebarData object
    for (let catagoryName in sidebarD) {

        //li tag contents
        let listItems = '';
        sidebarD[catagoryName].forEach(product => {
            listItems += `<li>${product}</li>`;
        });
        // console.log(listItems);


        //create html structure of side bar
        sidebarHtml += `
            <div class="filter-box">
                <h4>${catagoryName}</h4>
                <ul class="filter-list">
                    ${listItems}
                </ul>
            </div>
        
        `
    }
    sidebarContainer.innerHTML = sidebarHtml;
}

fetchProduct('all')


//workable side bar filters and make the selected item glow
let sidebarDiv = document.getElementById('dynamic-sidebar');
sidebarDiv.addEventListener('click', (e) => {

    if (e.target.tagName == 'LI') {

        let allList = sidebarDiv.querySelectorAll('li');
        allList.forEach(li => li.classList.remove('glow-text'));
        e.target.classList.add('glow-text');
        let parentOfProduct = e.target.innerText;

        fetch(`fetch_product.php?product_parent=${parentOfProduct}`)
            .then(response => response.json())
            .then(data => {
                
                productList.innerHTML = data.gridHtml;
                applyFilterCheck();
            })
            .catch(error => console.log(error)
            )
    }
})
// console.log(sidebarDiv);


//checkbox filter workable
/*
let allCheckBoxes = document.querySelectorAll('.price-check');

allCheckBoxes.forEach(box =>{
    box.addEventListener('change', () =>{

        let checkedBox = document.querySelectorAll('.price-check:checked');

        let allCards = document.querySelectorAll('.card');
        if(checkedBox.length === 0){
            allCards.forEach(cards => cards.style.display = 'block');
            return;
        }

        allCards.forEach(cards => cards.style.display = 'none');

        checkedBox.forEach(boxVal =>{
            let min = parseInt(boxVal.value.split('-')[0]);
            let max = parseInt(boxVal.value.split('-')[1]);
            console.log('min max is',min,max);


            allCards.forEach(cards =>{
                let priceText = cards.querySelector('strong').innerText;
                let price = parseInt(priceText.replace('₹', ''));

                if(price >= min && price <= max){
                    cards.style.display = 'block';
                }
            })
        })

        
    })
})

*/
function applyFilterCheck() {
    let checked = document.querySelectorAll('.price-check:checked');
    let allCards = document.querySelectorAll('.card');
    allCards.forEach(cards => {

        let price = parseInt(cards.querySelector('strong').innerText.replace('₹', ''));

        let show = false;
        if (checked.length === 0) {
            show = true;
        }

        checked.forEach(boxVal => {
            let [min, max] = boxVal.value.split('-');
            if (price >= min && price <= max) {
                show = true;
            }
        });
        cards.style.display = show ? 'block' : 'none';
    })

}

let allCheckBoxes = document.querySelectorAll('.price-check');

allCheckBoxes.forEach(box => {
    box.addEventListener('change', applyFilterCheck)
});
