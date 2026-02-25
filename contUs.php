<?php include 'partials/_navbar.php' ?>

    <div class="container-fluid p-0 mb-4 mb-md-5">
        <div class="d-flex flex-column justify-content-center align-items-center text-center text-white px-3" 
             style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('partials/images/contactUsBanner.png') top center/cover no-repeat; min-height: 400px;">
             
            <h1 class="d-md-none fw-bold mb-2 shadow-sm fs-1">CONTACT US</h1>
            <h1 class="d-none d-md-block display-4 fw-bold mb-2 shadow-sm">CONTACT US</h1>
            
            <p class="fs-6 fs-md-4 fw-light">We'd love to hear from you!</p>
        </div>
    </div>

    <div class="container my-4 my-md-5">
        <div class="row bg-white shadow-sm rounded-4 p-3 p-md-5 mx-1 mx-md-0">
            
            <div class="col-lg-5 mb-5 mb-lg-0 pe-lg-5">
                <h2 class="fw-bold mb-4 fs-3 fs-md-2">Get in Touch</h2>
                
                <div class="d-flex mb-4 align-items-center align-items-md-start">
                    <i class="bi bi-geo-alt-fill fs-4 me-3 mt-md-1" style="color: #0d5c25;"></i>
                    <div>
                        <h6 class="fw-bold mb-1 fs-6">Address.</h6>
                        <p class="text-muted mb-0 small small-md-p">123, Market Street, Kolkata - 700001</p>
                    </div>
                </div>

                <div class="d-flex mb-4 align-items-center align-items-md-start">
                    <i class="bi bi-telephone-fill fs-4 me-3 mt-md-1" style="color: #0d5c25;"></i>
                    <div>
                        <h6 class="fw-bold d-md-none mb-1 fs-6">Phone.</h6>
                        <p class="text-muted mb-0 small small-md-p d-none d-md-block mt-1">Phone: +91 98765 43210</p>
                        <p class="text-muted mb-0 small d-md-none">+91 98765 43210</p>
                    </div>
                </div>

                <div class="d-flex mb-4 align-items-center align-items-md-start">
                    <i class="bi bi-envelope-fill fs-4 me-3 mt-md-1" style="color: #0d5c25;"></i>
                    <div>
                         <h6 class="fw-bold d-md-none mb-1 fs-6">Email.</h6>
                        <p class="text-muted mb-0 small small-md-p d-none d-md-block mt-1">Email: support@grocery.com</p>
                        <p class="text-muted mb-0 small d-md-none">support@grocery.com</p>
                    </div>
                </div>

                <div class="mt-4 mt-md-5">
                    <h6 class="fw-bold mb-3 fs-6 fs-md-5">Social Us</h6>
                    <div class="d-flex gap-3 fs-5">
                        <a href="#" style="color: #0d5c25;"><i class="bi bi-facebook"></i></a>
                        <a href="#" style="color: #0d5c25;"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" style="color: #0d5c25;"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <h2 class="fw-bold mb-4 fs-3 fs-md-2">Send Us a Message</h2>
                <form id ="messageForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" name="name" class="form-control form-control-md form-control-md-lg bg-light border-0 py-2 py-md-3" placeholder="Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="email" name="email" class="form-control form-control-md form-control-md-lg bg-light border-0 py-2 py-md-3" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="subject" class="form-control form-control-md form-control-md-lg bg-light border-0 py-2 py-md-3" placeholder="Subject" required>
                    </div>
                    <div class="mb-4">
                        <textarea class="form-control form-control-md form-control-md-lg bg-light border-0 py-2 py-md-3" name="message" rows="4" placeholder="Message" required></textarea>
                    </div>
                    <button type="submit" class="btn text-white px-4 px-md-5 py-2 py-md-3 rounded-pill shadow-sm w-100 w-md-auto fw-bold" style="background-color: #0d5c25;">
                        Send Message
                    </button>
                </form>
            </div>

        </div>
    </div>
<script src="assets/contUs.js"></script>
<?php include 'partials/_footer.php' ?>