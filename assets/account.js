console.log('account.js page');

function account(){
    const signinForm = document.getElementById('signinForm');
    if(signinForm){
        signinForm.addEventListener('submit', (e) =>{
            e.preventDefault();
            console.log('sign in form submitted');
            
            let form = new FormData(e.target);
            form.append('submit_action', true);

            fetch('partials/_handel_account.php', {
                method: 'POST',
                body: form
            })
            .then(response => response.text())
            .then(data => {
                console.log('signin data is: -> ', data);
                showMessage(data);
                // e.target.reset();
            })
            .catch(error => console.log(error))
        })
    }

    const loginForm = document.getElementById('loginForm');
    if(loginForm){
        loginForm.addEventListener('submit', (e) =>{
            e.preventDefault();
            console.log('login form submitted');
            let form = new FormData(e.target);
            form.append('login_action', true);

            fetch('partials/_handel_account.php', {
                method: 'POST',
                body: form
            })
            .then(response => response.text())
            .then(data => {
                console.log('login data is ->', data);
                showMessage(data);
                // e.target.reset();

            })
            .catch(error => console.log(error)) 
        })
    }
}


account();

let showMsg = document.getElementById('showMsg');

function openPopup(id) {
    document.getElementById(id).style.display = 'flex';
}

function closePopup(id) {
    document.getElementById(id).style.display = 'none';
    clearErrors(); 
}

//  (Login <-> Register)
function switchPopup(hideId, showId) {
    closePopup(hideId);
    openPopup(showId);
}


function showMessage(data) {
    clearErrors();
    let msg = data.trim();

    if (msg == 'success') {

        let username = document.querySelector('#loginForm input[name="username"]');
        let loginBox = document.querySelector('#loginOverlay');
        loginBox.innerHTML = `
                <div class="text-center bg-white rounded p-5">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem; animation: popIn 0.5s;"></i>
                    <h2 class="text-success fw-bold mt-3">WELCOME BACK</h2>
                    <h3 class="text-dark fw-bold mt-2 text-uppercase">${username.value}</h3>
                    <p class="text-muted mt-3">Logging you in...</p>
                    <div class="spinner-border text-success spinner-border-sm" role="status"></div>
                </div>
        
        
        `;
        
        setTimeout(() => {
            location.reload();
        }, 2000);
    } 
    else if (msg == 'success_sign') {
        let registerBox = document.querySelector("#signinOverlay");
        registerBox.innerHTML = `
            <div class="text-center bg-white rounded p-4">
                <h3 class="text-success fw-bold mb-3">Registration Successful!</h3>
                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem; animation: popIn 0.5s;"></i>
                <p class="text-muted fw-bold">Redirecting to Login...</p>
                <div class="mt-3 text-center">
                    <small>Login manually 
                        <a href="#" onclick="switchPopup('signinOverlay', 'loginOverlay')" class="text-decoration-none fw-bold">Login</a>
                    </small>
                </div>
            </div>
        `;
        
        // close the Register and open Login 
        setTimeout(() => {
            switchPopup('signinOverlay', 'loginOverlay');
        }, 3000);
        
    }
    
    else if (msg == 'wrong_user') {
        document.getElementById('error_log_name').innerText = "Username not found";
    }else if(data == 'wrong password'){
        document.getElementById('error_log_pass').innerText = "Incorrect password";
    }else if(data == 'user_exist'){
        document.getElementById('error_sign_name').innerText = "Username already exist";
    }else if(data == 'email_exist'){
        document.getElementById('error_email').innerText = "Email already exist";
    }else if(data == 'phone_exist'){
        document.getElementById('error_phone').innerText = "Phone no already exist";
    }else if(data == 'password_mismatched'){
        document.getElementById('error_sign_pass').innerText = "Passwords do not match!";
    }else{
        let activeBox = null;
        if(document.getElementById('loginOverlay').style.display == 'flex'){
            activeBox = document.querySelector('#loginOverlay');
        }else if(document.getElementById('signinOverlay').style.display == 'flex'){
            activeBox = document.querySelector('#signinOverlay');
        }
        activeBox.innerHTML = `
                <div class="text-center py-5">
                    <i class="bi bi-hdd-network-fill text-danger" style="font-size: 4rem; animation: shake 0.5s;"></i>
                    <h3 class="text-danger fw-bold mt-4">SOMETHING WENT WRONG!</h3>
                    <p class="text-muted fw-bold mt-2">Server is not responding...</p>
                    <button onclick="location.reload()" class="btn btn-outline-danger mt-3 btn-sm rounded-pill px-4">
                        Try Again
                    </button>
                </div>
            `;
    }
}



//clear the red text of form
function clearErrors(){
    let ids = ['error_log_pass', 'error_log_name', 'error_sign_name', 'error_sign_pass'];
    ids.forEach(id => {
        let elem = document.getElementById(id);
        if (elem) elem.innerText = '';
    })
}





