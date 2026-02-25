console.log('contus js');

let messageForm = document.getElementById('messageForm');
messageForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let form = new FormData(e.target);
    form.append('msg_action', 'msg_send');
    fetch('partials/_msgCustomer.php',{
        method: 'POST',
        body: form
    })
    .then(response => response.text())
    .then(data => {
        if(data.trim() == 'message send'){
            showMyAlert(data);
            messageForm.reset();
        }else{
            showMyAlert(data);
        }
        
    })
    .catch(error => console.log(error))
})
