<div id="signinOverlay" class="auth-overlay">
    <div class="auth-box">
        <span class="close-icon" onclick="closePopup('signinOverlay')">&times;</span>
        
        <h3 class="text-center mb-4 fw-bold">Register</h3>
        
        <form id="signinForm">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
                <small id="error_sign_name" class="text-danger fw-bold"></small>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                <small id="error_email" class="text-danger fw-bold"></small>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone no.</label>
                <input type="tel" name="phone" class="form-control" placeholder="Phone Number" pattern="[0-9]{10}" required>
                <small id="error_phone" class="text-danger fw-bold"></small>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="cpassword" class="form-control" required>
                <small id="error_sign_pass" class="text-danger fw-bold"></small>
            </div>
            
            <button type="submit" class="btn btn-success w-100 py-2">Sign Up</button>
            
            <div class="mt-3 text-center">
                <small>Already have an account? 
                    <a href="#" onclick="switchPopup('signinOverlay', 'loginOverlay')" class="text-decoration-none fw-bold">Login</a>
                </small>
            </div>
        </form>
    </div>
</div>