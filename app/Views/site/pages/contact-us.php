<?= view('site/newLanding/header', ['globalSettings' => $globalSettings, 'css' => $css]); ?>

<div class="container my-5">
    <section>
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold text-primary" style="font-family: 'Alumni Sans', sans-serif;">Contact Us</h1>
                <p class="text-muted lead">Items are reserved for 60 minutes</p>
            </div>
        </div>

        <div class="row justify-content-center g-5">
            <!-- Contact Information Section -->
            <div class="col-lg-6 col-12">
                <div class="card shadow-lg rounded-4">
                    <div class="card-body p-4">
                        <img src="/theme/image/Group 626.svg" class="img-fluid mb-4 rounded-3" alt="Contact Us Image">
                        <div class="d-flex flex-column flex-md-row mb-4">
                            <div class="col-md-6 col-12">
                                <h5 class="fw-bold" style="font-family: 'Alumni Sans', sans-serif;">Address</h5>
                                <p class="text-muted">You can reach us at this address:</p>
                            </div>
                            <div class="col-md-6 col-12">
                                <h5 class="fw-bold" style="font-family: 'Alumni Sans', sans-serif;">Phone</h5>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-telephone-forward text-primary"></i> <a href="tel:+9710549983130">+92 047776573130</a></li>
                                    <li><i class="bi bi-telephone-forward text-primary"></i> <a href="tel:+9710549983130">+92 054976575670</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Online Services Section -->
                        <h4 class="fw-bold text-primary mb-3">Online Services</h4>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-globe2 text-primary"></i> <a href="http://www.zappta.com" target="_blank">www.zappta.com</a></li>
                            <li><i class="bi bi-envelope text-primary"></i> <a href="mailto:zappta@gmail.com">zappta@gmail.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Contact Form Section -->
            <div class="col-lg-4 col-12">
                <div class="card shadow-lg rounded-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4 text-center">Get in Touch</h4>
                        <form method="post" action="<?php print base_url() . '/contact-us'; ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Your Name">
                                <div id="errorForm" class="text-danger mt-2"></div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Your Email">
                                <div id="errorForms" class="text-danger mt-2"></div>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea id="message" class="form-control" name="message" rows="4" placeholder="Your Message"></textarea>
                                <div id="errorFormss" class="text-danger mt-2"></div>
                            </div>

                            <input type="hidden" id="_vendor_login_token" value="<?php print csrf_hash() ?>">

                            <button type="button" class="btn btn-warning w-100 py-2" style="font-weight: bold;" onclick="SendMessage()">Submit</button>

                            <div id="SuccessMessage" class="text-success mt-3"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>

<script type="text/javascript">
    function SendMessage() {
        var name = $('#name').val();
        var email = $('#email').val();
        var message = $('#message').val();
        var csrf_token = $('#_vendor_login_token').val();
        let errors = 0;

        // Clear previous errors
        jQuery('#errorForm,#errorForms,#errorFormss').text('');

        if (name == '') {
            $('#errorForm').html('<p class="alert alert-danger">Please Enter Your Name</p>');
            errors++;
        } else if (email == '') {
            $('#errorForms').html('<p class="alert alert-danger">Please Enter Your Email</p>');
            errors++;
        } else if (message == '') {
            $('#errorFormss').html('<p class="alert alert-danger">Please Enter Your Message</p>');
            errors++;
        } else {
            $.ajaxSetup({
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token);
                }
            });
            $.ajax({
                url: baseUrl + '/contact-us',
                type: 'POST',
                data: {
                    'name': name,
                    'email': email,
                    'message': message,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                dataType: 'JSON',
                success: function(resp) {
                    if (resp != '') {
                        $('#SuccessMessage').html('<p class="alert alert-success">Your Message has been Sent Successfully!</p>');
                        setTimeout(function() {
                            window.location.href = "";
                        }, 5000);
                    }
                }
            });
        }
    }
</script>
