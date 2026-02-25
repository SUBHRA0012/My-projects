
let orderTableBody = document.querySelector('.table tbody');

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