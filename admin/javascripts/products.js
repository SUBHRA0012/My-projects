console.log('product js');
let productForm = document.getElementById('productForm');
    let label = document.getElementById('addProductModalLabel');
    let oldLabel = label.innerHTML;
if (productForm) {
    productForm.addEventListener('submit', (e) => {

        if (productForm.classList.contains('is-editing')) return true;

        e.preventDefault();
        let form = new FormData(e.target);
        fetch('components/_product_upload.php', {
            method: 'POST',
            body: form
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status == 'success') {
                    let p = data.products;
                    let priceHtml = ``;
                    priceHtml += `₹${p.price} <span class="text-muted fw-normal small">/ ${p.unit}</span>`;
                    if (parseFloat(p.old_price) > parseFloat(p.price)) {
                        priceHtml += `<span class="text-muted text-decoration-line-through me-1 small">₹ ${p.old_price}</span>`;
                    }

                    let tableHtml = `
                <tr id=${p.id}>
                    <td>
                        <img src="../partials/images/productImages/${p.image}" alt="Product" 
                        class="rounded border" width="50" height="50" style="object-fit: cover;" onerror="this.src='https://placehold.co/50x50'">
                    </td>
                    <td class="fw-bold text-dark">${p.product_name}</td>
                    <td class="text-muted">${p.category}</td>
                    <td class="fw-bold text-success">
                        ${priceHtml}
                    </td>
                    <td><span class="badge bg-success bg-opacity-10 text-success px-2 py-1">${p.stock} ${p.unit}</span></td>
                    <td>
                        <button class="btn edit-btn btn-sm btn-primary me-1" edit-id="${p.id}"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn delete-btn btn-sm btn-danger" data-id="${p.id}"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                `;

                    let tbody = document.querySelector('.table tbody');
                    tbody.insertAdjacentHTML('afterbegin', tableHtml);
                    productForm.reset();
                    productForm.classList.remove('is-editing');
                    document.activeElement.blur(); //used to avoid area-hidden warning in console
                    let modalElement = document.getElementById('addProductModal');
                    let modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                    } else {
                        document.querySelector('#addProductModal .btn-close').click();
                    }
                } else {
                    console.log('error:' + data.message);

                }

            })
            .catch(error => console.log(error))
    })
}

document.addEventListener('click', (e) => {
    let deleteBtn = e.target.closest('.delete-btn');
    let editBtn = e.target.closest('.edit-btn');
    if (deleteBtn) {
        if (!confirm("Are you sure you want to delete this item?")) return;
        productId = deleteBtn.getAttribute('data-id');
        console.log(productId);
        let tr = document.getElementById(productId);
        console.log(tr);
        let form = new FormData();
        form.append('delete_tr', productId);
        fetch('components/_product_upload.php', {
            method: 'POST',
            body: form
        })
            .then(response => response.text())
            .then(data => {
                console.log(data);

                if (data == 'deleted') {
                    tr.remove();
                }
            })

    }
    
    if (editBtn) {
        editProductId = editBtn.getAttribute('edit-id');
        let tr = document.getElementById(editProductId);
        label.innerHTML = '<i class="bi bi-pencil-square"></i> Edit Product';
        console.log(label);
        
        let formData = new FormData();

        formData.append('edit_tr_data', editProductId);
        fetch('components/_product_upload.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {

                if (data.status == 'edited') {
                    let p = data.data;
                    let form = document.getElementById('productForm');

                    form.elements['product_name'].value = p.product_name;
                    form.elements['price'].value = p.price;
                    form.elements['old_price'].value = p.old_price;
                    form.elements['product_desc'].value = p.product_desc;
                    form.elements['detail_desc'].value = p.detail_desc;
                    form.elements['stock'].value = p.stock;

                    let imageNames = {
                        'image': p.image,
                        'thumb_img1': p.thumb_img1,
                        'thumb_img2': p.thumb_img2,
                        'thumb_img3': p.thumb_img3,
                        'thumb_img4': p.thumb_img4

                    };
                    for (let key in imageNames) {
                        if (!imageNames[key]) continue;
                        let inputField = form.querySelector(`[name="${key}"]`);
                        inputField?.removeAttribute('required')
                        inputField?.parentElement?.querySelector('.old-img-preview')?.remove();
                        inputField?.insertAdjacentHTML('afterend', `<img src="../partials/images/productImages/${imageNames[key]}" 
                            class="old-img-preview mt-2 rounded border shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">`);
                    }

                    form.elements['category_id'].value = p.category_id + '|' + p.category_name;

                    let oldInput = form.querySelector('input[name="edit_product_id"]');
                    if (oldInput) oldInput.remove();

                    // নতুন হিডেন ইনপুট যোগ করা
                    form.insertAdjacentHTML('beforeend', `<input type="hidden" name="edit_product_id" value="${p.id}">`);
                    form.classList.add('is-editing');

                    // ৩. মোডাল (পপ-আপ) ওপেন করা
                    let myModal = new bootstrap.Modal(document.getElementById('addProductModal'));
                    myModal.show();
                }

            })
    }
});

//update product pic preview
productForm.addEventListener('change', function (e) {
    if (e.target.type === 'file' && e.target.files[0]) {
        e.target.parentElement.querySelectorAll('img').forEach(img => img.remove());
        e.target.insertAdjacentHTML('afterend', `<img src="${URL.createObjectURL(e.target.files[0])}" 
        class="mt-2 rounded border shadow-sm live-preview" width="60" height="60" style="object-fit: cover;">`);
    }
})

document.getElementById('addProductModal').addEventListener('hidden.bs.modal', () => {
    productForm.reset();
    label.innerHTML = oldLabel;
    productForm.classList.remove('is-editing');
    productForm.querySelector('[name="edit_product_id"]')?.remove();
    document.querySelectorAll('.old-img-preview').forEach(img => img.remove());
    ['image', 'thumb_img1', 'thumb_img2', 'thumb_img3', 'thumb_img4'].forEach(name => {
        productForm.querySelector(`[name="${name}"]`)?.setAttribute('required', 'required');

    });
    productForm.querySelectorAll('img').forEach(img => img.remove());
})

let tableContent = document.querySelector('.table tbody');

let searchProductInput = document.getElementById('searchProductInput');
let categoryFilter = document.getElementById('categoryFilter');


const filterProduct = () => {
    let searchText = searchProductInput?.value.toLowerCase() || '';
    let dropValue = categoryFilter?.value || 'All';
    let tr = tableContent.querySelectorAll('tr');
    tr.forEach(tr => {
        let trText = tr.textContent.toLocaleLowerCase();
        let tdCat = tr.querySelectorAll('td')[2]?.textContent;
        let searchBoxMatch = trText.includes(searchText);
        let dropValueMatch = (dropValue === 'All' || tdCat === dropValue)
        if (searchBoxMatch && dropValueMatch) {
            tr.style.display = '';
        } else {
            tr.style.display = 'none';
        }

    })
}
searchProductInput?.addEventListener('input', filterProduct);
categoryFilter?.addEventListener('change', filterProduct);



