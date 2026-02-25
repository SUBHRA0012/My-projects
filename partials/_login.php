<div id="loginOverlay" class="auth-overlay">
    <div class="auth-box">
        <span class="close-icon" onclick="closePopup('loginOverlay')">&times;</span>
        
        <h3 class="text-center mb-4 fw-bold">Login</h3>
        
        <form id="loginForm">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
                <small id="error_log_name" class="text-danger fw-bold"></small>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                <small id="error_log_pass" class="text-danger fw-bold"></small>
            </div>
            
            <button type="submit" class="btn btn-success w-100 py-2">Login</button>
            
            <div class="mt-3 text-center">
                <small>Don't have an account? 
                    <a href="#" onclick="switchPopup('loginOverlay', 'signinOverlay')" class="text-decoration-none fw-bold">Register</a>
                </small>
            </div>
        </form>
    </div>
</div>