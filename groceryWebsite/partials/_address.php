<!-- select exited address -->
<div id="addressOverlay" class="auth-overlay">
    <div class="auth-box" style="max-width: 500px;">
        <span class="close-icon" onclick="closePopup('addressOverlay')">&times;</span>

        <h4 class="mb-4 fw-bold">Select Delivery Address</h4>

        <div id="address-container">

            <div id="address-list-container" style="max-height: 400px; overflow-y: auto;">
            </div>

            <div class="mt-4">
                <button type="button" onclick="saveAddressAndClose()" class="btn btn-success w-100 py-2 fw-bold">
                    Deliver Here
                </button>

                <div class="text-center mt-3">
                    <a href="javascript:void(0)" onclick="resetAndOpenAdd()" class="text-decoration-none fw-bold text-primary">
                        <i class="fas fa-plus-circle me-1"></i> Add New Address
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- add new address -->

<div id="changeAddOverlay" class="auth-overlay">
    <div class="auth-box" style="max-width: 500px;">
        <span class="close-icon" onclick="closePopup('changeAddOverlay')">&times;</span>
        <h5 class="mb-4 fw-bold">Add New Address</h5>

        <form id="addNewAddressForm" onsubmit="submitNewAddress(event)">
            <input type="hidden" name="address_id" id="hidden_address_id">
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="col-6">
                    <input type="tel" name="phone" class="form-control" placeholder="Phone Number" pattern="[0-9]{10}" required>
                </div>
            </div>

            <div class="row g-2 mb-3">
                <div class="col-6">
                    <input type="text" name="pincode" class="form-control" placeholder="Pincode" pattern="[0-9]{6}" required>
                </div>
                <div class="col-6">
                    <input type="text" name="locality" class="form-control" placeholder="Locality (e.g. Near Mall)">
                </div>
            </div>

            <div class="mb-3">
                <textarea name="address_line1" class="form-control" rows="2" placeholder="Flat/House No, Building, Street" required></textarea>
            </div>

            <div class="mb-3">
                <select name="state" class="form-select" required>
                    <option value="West Bengal">West Bengal</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label d-block text-muted small">Address Type</label>
                <div class="btn-group w-100" role="group">
                    <input type="radio" class="btn-check" name="address_type" id="typeHome" value="Home" checked>
                    <label class="btn btn-outline-success btn-sm" for="typeHome">Home</label>

                    <input type="radio" class="btn-check" name="address_type" id="typeWork" value="Work">
                    <label class="btn btn-outline-primary btn-sm" for="typeWork">Work</label>

                    <input type="radio" class="btn-check" name="address_type" id="typeOther" value="Other">
                    <label class="btn btn-outline-secondary btn-sm" for="typeOther">Other</label>
                </div>
            </div>

            <button type="submit" class="btn btn-dark w-100 fw-bold">Save Address</button>
            <div class="text-center mt-2">
                <a href="javascript:void(0)" onclick="switchPopup('changeAddOverlay', 'addressOverlay')" class="text-decoration-none small text-muted">Cancel</a>
            </div>
        </form>
    </div>
</div>