console.log('message js here');

let adminReplyForm = document.getElementById('adminReplyForm');

document.addEventListener('click', (e) => {
    if (e.target.closest('.reply-btn')) {
        let msgSno = e.target.getAttribute('msg-sno');
        document.getElementById('hidden_sno').value = msgSno;

        let msgName = e.target.getAttribute('msg-Name');
        document.getElementById('replyModalLabel').innerText = `Reply to Message #${msgSno} (${msgName})`;

        let msgText = e.target.getAttribute('msg-Text');
        document.getElementById('fullMsg').innerText = msgText;


    }
});


let replyModal = document.getElementById('replyModal');
let submitBtn = replyModal.querySelector('button[type="submit"]');

adminReplyForm.addEventListener('submit', (e) => {
    e.preventDefault();
    submitBtn.disabled = true;
    submitBtn.innerText = 'Sending reply...'
    let form = new FormData(e.target);
    fetch('components/_send_reply.php', {
        method: 'POST',
        body: form
    })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === 'success') {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Send Reply';
                adminReplyForm.reset();
                let myModalEl = document.getElementById('replyModal');
                let modal = bootstrap.Modal.getInstance(myModalEl);
                modal.hide();
                let sno = document.getElementById('hidden_sno').value;
                let targetBtn = document.getElementById('btn-' + sno);
                if (targetBtn) {
                    targetBtn.classList.remove('btn-primary', 'reply-btn');
                    targetBtn.classList.add('btn-success', 'disabled');    
                    targetBtn.innerHTML = '<i class="bi bi-check-circle"></i> Replied';                       
                    targetBtn.removeAttribute('data-bs-toggle');
                }
            } else {
                alert('Error: ', data);
            }

        })
        .catch(error => {
            submitBtn.disabled = false;
            submitBtn.innerText = 'Send Reply';
            console.log(error);
        })
})


let tableBody = document.querySelector('.table tbody');
let searchMsgInput = document.getElementById('searchMsgInput');
let statusFilter = document.getElementById('statusFilter');

const searchBox = () => {
    let searchTxt = searchMsgInput.value.toLowerCase();
    let tableRow = tableBody.querySelectorAll('tr');
    let dropValue = statusFilter.value;
    tableRow.forEach(tr => {
        let tableText = tr.textContent.toLocaleLowerCase();
        let action = tr.querySelector('button').textContent.trim();
        let dropValueMatch = (dropValue == 'All' || action == dropValue);
        let searchBoxMatch = tableText.includes(searchTxt);
        if(searchBoxMatch && dropValueMatch){
            tr.style.display = '';
        }else{
            tr.style.display = 'none';
        }
    })
    
}

searchMsgInput.addEventListener('input', searchBox);
statusFilter.addEventListener('change', searchBox);