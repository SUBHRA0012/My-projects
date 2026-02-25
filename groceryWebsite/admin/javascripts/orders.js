
console.log('orders js');

let orderTableBody = document.getElementById('orderTableBody');

fetch('components/_order_table.php')
    .then(response => response.text())
    .then(data => {
        if (data == 'failed') {
            return;
        }
        orderTableBody.innerHTML = data;
    })
    .catch(error => console.log(error))



    
orderTableBody.addEventListener('change', (e) => {
    if (e.target.classList.contains('status-dropdown')) {
        let newStatus = e.target.value;
        let dropdownId = e.target.getAttribute('data-order-id');

        let form = new FormData();
        form.append('new_status', newStatus);
        form.append('status_id', dropdownId);

        fetch('components/_update_order_status.php', {
            method: 'POST',
            body: form
        })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                if (data == 'updated') {
                    if (newStatus == 'Delivered') {
                        e.target.setAttribute('disabled', 'true');
                        e.target.classList = 'form-select form-select-sm status-dropdown text-success border-success';
                    }else if(newStatus == 'Cancelled'){
                        e.target.setAttribute('disabled', 'true');
                        e.target.classList = 'form-select form-select-sm status-dropdown text-danger border-danger';
                    }
                }
            })
    }
});


let searchOrderInput = document.getElementById('searchOrderInput');
let statusFilter = document.getElementById('statusFilter');
const filterTable = () =>{
    let search = searchOrderInput?.value.toLowerCase() || '';
    let filter = statusFilter?.value || 'All';

    let row = orderTableBody.querySelectorAll('tr');
    row.forEach(tr => {
        let rowText = tr.textContent.toLowerCase();
        let rowStatusDropdown = tr.querySelector('.status-dropdown');
        let rowStatus = rowStatusDropdown?.value || '';

        let matchText = rowText.includes(search);
        let matchStatus = (filter == 'All' || rowStatus == filter);
        if(matchText && matchStatus){
            tr.style.display = '';
        }else{
            tr.style.display = 'none';
        }
    })
}

searchOrderInput?.addEventListener('input', filterTable);

statusFilter?.addEventListener('change', filterTable);

// ====== View Details Button Click ======
orderTableBody.addEventListener('click', (e) => {
    //  view-btn click
    if(e.target.classList.contains('view-btn')) {
        let orderId = e.target.getAttribute('data-order-id');
        let modalBody = document.getElementById('orderDetailsContent');
        
        let formData = new FormData();
        formData.append('order_id', orderId);

        fetch('components/_get_order_items.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {

            modalBody.innerHTML = data; 
        })
        .catch(error => console.log(error));
    
        let printBtn = document.getElementById('printInvoiceBtn');
        if(printBtn) {
            printBtn.href = 'components/_admin_invoice.php?id=' + orderId;
        }
    
    }
});


