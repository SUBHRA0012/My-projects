
let userTableBody = document.getElementById('userTableBody');

fetch('components/_user_table.php')
.then(response => response.text())
.then(data => {
    // console.log(data);
    
    userTableBody.innerHTML = data;
});



const sendUserAction = (formFetch, callback) =>{
    fetch('components/_view_user.php', {
        method: 'POST',
        body: formFetch
    })
    .then(response => response.text())
    .then(data => {
        callback(data);
    })
    .catch(error => console.log(error));
}


userTableBody.addEventListener('click', (e) => {
    let viewBtn = e.target.closest('.view-btn');
    if(viewBtn){
        
        let form = new FormData();
        form.append('action', 'view');
        form.append('user_id', viewBtn.getAttribute('data-user-id'));
        let userDetailsContent = document.getElementById('userDetailsContent');
        sendUserAction(form, (data) => {
            userDetailsContent.innerHTML = data;
        })        
       return;
    }

    let blockBTn = e.target.closest('.block-btn');
    if(blockBTn){
        let form = new FormData();
        form.append('action', 'toggle_status');
        form.append('user_id', blockBTn.getAttribute('data-user-id'));
        form.append('data_status', blockBTn.getAttribute('data-status'));

        sendUserAction(form, (data) => {
            if(data.trim() == 'success'){
                window.location.reload();
            }else{
                console.log('failed to update status');  
            }
        })
    }
})



let searchUserInput = document.getElementById('searchUserInput');
let statusUserFilter = document.getElementById('statusUserFilter');

const filterTable = () =>{
    let search = searchUserInput?.value.toLowerCase() || '';
    let filter = statusUserFilter?.value || 'All';
    let row = userTableBody.querySelectorAll('tr');
    row.forEach(tr => {
        let rowText = tr.textContent.toLowerCase();
        let rowStatusState = tr.querySelectorAll('td')[5];
        
        let rowStatus = rowStatusState?.textContent.trim() || '';
        

        let matchText = rowText.includes(search);
        let matchStatus = (filter == 'All' || rowStatus == filter);
        if(matchText && matchStatus){
            tr.style.display = '';
        }else{
            tr.style.display = 'none';
        }
    })
}

searchUserInput?.addEventListener('input', filterTable);
statusUserFilter?.addEventListener('change', filterTable);