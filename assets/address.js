console.log('address js for cart.php');

const openAddressManager = () =>{
    openPopup('addressOverlay');

    //loading icon showing
    let container = document.getElementById('address-list-container');
    container.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-success"></div></div>';

    let form = new FormData();
    form.append('action', 'fetch_addresses');

    fetch('partials/_handel_address.php', {
        method: 'POST',
        body: form
    })
    .then(response => response.text())
    .then(data => {
        container.innerHTML = data;
    })
    .catch(error => console.log(error)
    )
}
//select the address and save
const saveAddressAndClose = () =>{
    //find the selected button 
    let selected = document.querySelector('input[name="selected_address"]:checked');

    if(!selected){
        showMyAlert("please select and address");
        return;
    }

    //send to server
    let form = new FormData();
    form.append('action', 'save_active_address');
    form.append('address_id', selected.value);

    fetch('partials/_handel_address.php', {
        method: 'POST',
        body: form
    })
    .then(response => response.text())
    .then(data => {
        if(data.trim() === "success"){
            closePopup('addressOverlay');
            loadCartData();
        }
    })
}

//submit the new address form
const submitNewAddress = (e) =>{
    e.preventDefault();
    
    let newAddressForm = document.getElementById('addNewAddressForm');
    let form = new FormData(newAddressForm);
    form.append('action', 'add_new_address');

    fetch('partials/_handel_address.php', {
        method: 'POST',
        body: form
    })
    .then(response => response.text())
    .then(data => {
        if(data.trim() === "success"){
            newAddressForm.reset();

            switchPopup('changeAddOverlay', 'addressOverlay');
            openAddressManager();
        }else{
            showMyAlert("Something went Wrong");
        }
    });
}
//edit address
const openEditMode = (btn) => {
    switchPopup('addressOverlay', 'changeAddOverlay');

    let d = btn.dataset;

    let form = document.getElementById('addNewAddressForm');
    document.getElementById('hidden_address_id').value = d.id;
    form.name.value = d.name;
    form.phone.value = d.phone;
    form.pincode.value = d.pincode;
    form.locality.value = d.locality;
    form.address_line1.value = d.line1;
    form.state.value = d.state;

    let radios = form.elements['address_type'];
    for (let i = 0; i < radios.length; i++) {
        if(radios[i].value === d.type) {
            radios[i].checked = true;
            break;
        }
    }

}

//reset and open
const resetAndOpenAdd = () => {
    document.getElementById('addNewAddressForm').reset();
    document.getElementById('hidden_address_id').value = '';
    switchPopup('addressOverlay', 'changeAddOverlay');
}

//delete address 
const deleteAddress = (id) => {
    if(!confirm("Are you sure you want to delete this address?")){
        return;
    }

    let form = new FormData();
    form.append('action', 'delete_address');
    form.append('del_id', id);

    fetch('partials/_handel_address.php', {
        method: 'POST',
        body: form
    })
    .then(response => response.text())
    .then(data => {
        if(data.trim() === "success"){
            openAddressManager();
            loadCartData();
        }else{
            showMyAlert("Delete Faild!");
        }
    });
}
