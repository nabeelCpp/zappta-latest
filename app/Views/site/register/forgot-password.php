<?php print view('site/header'); ?>
<section class="py-5">
    <div class="container">
        <div class="resetPasswordSection">
            <div class="modalLogo">
                <a href="<?=base_url()?>"><img src="<?= base_url() . '/upload/logo/' . $globalSettings[0]['var_detail'] ?>" class="img img-responsive w-25" alt="Logo" /></a>
            </div>
            <h2>Forgot Password</h2>
            <form class="loginSignup-form" id="resetPasswordForm" method="post" action="<?= route_to('forgot.password.post') ?>" data-id="email">
                <div class="fieldset mb-3">
                    <label class="image-replace cd-email" for="signin-email">Email</label>

                    <div class="fieldSection">
                        <div class="formIcon"><img src="<?= $assets_url ?>/img/Email.svg" alt="" /></div>
                        <input class="full-width has-padding has-border" id="email" type="email" placeholder="User Email">
                        <span class="text-danger d-none" ><i class="fa fa-exclamation-circle"></i></span>
                    </div>
                    <small class="text-danger errorMsgDiv"></small>

                </div>
                <div class="fieldset mt-5">
                    <input class="full-width submitBtn" type="submit" value="Send OTP">
                </div>
            </form>
            <form class="loginSignup-form d-none" id="verifyOtp" method="post" action="<?= route_to('forgot.password.otp') ?>" data-id="otp">
                <div class="fieldset mb-3">
                    <label class="image-replace cd-email" for="signin-email">Enter OTP</label>

                    <div class="fieldSection">
                        <input class="full-width has-padding has-border" id="otp" type="text" placeholder="Enter OTP">
                        <span class="text-danger d-none" ><i class="fa fa-exclamation-circle"></i></span>
                    </div>
                    <small class="text-danger errorMsgDiv"></small>

                </div>
                <div class="fieldset mt-5">
                    <input class="full-width submitBtn" type="submit" value="Reset">
                </div>
            </form>
            <form class="loginSignup-form d-none" id="resetForm" method="post" action="<?= route_to('forgot.password.reset') ?>" data-id="reset">
                <div class="fieldset mb-3">
                    <label class="image-replace cd-email" for="signin-email">New Password</label>
                    <div class="fieldSection">
                        <div class="formIcon"><img src="<?=$assets_url?>/img/lock.svg" alt="" /></div>
                        <input class="full-width has-padding has-border" id="new-password" type="password" placeholder="New Password">
                        <!-- <a href="#0" class="hide-password"><img src="<?=$assets_url?>/img/eye-slash.svg" alt="" /></a> -->
                    </div>
                    <small class="text-danger errorMsgDiv"></small>
                </div>
                <div class="fieldset">
                    <label class="image-replace cd-email" for="signin-email">Confirm Password</label>

                    <div class="fieldSection">
                        <div class="formIcon"><img src="<?=$assets_url?>/img/lock.svg" alt="" /></div>
                        <input class="full-width has-padding has-border" id="confirm-password" type="password" placeholder="Confirm Password">
                        <!-- <a href="#0" class="hide-password"><img src="<?=$assets_url?>/img/eye-slash.svg" alt="" /></a> -->
                    </div>
                    
                </div>
                <div class="fieldset mt-5">
                    <input class="full-width submitBtn" type="submit" value="Confirm">
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    $('#resetPasswordForm, #verifyOtp, #resetForm').submit(function(e) {
        e.preventDefault();
        let _this = $(this);
        let id = _this.data('id');
        let type = _this.attr('method');
        
        let url = _this.attr('action');
        let csrf_name = $('meta[name="csrf_token_name"]').attr('content');
        switch (id) {
            case 'otp':
                var field = $('#otp');
                var otp = field.val();
                var email = $('#email').val();
                if (!otp) {
                    addError(field, 'OTP is required');
                    return false;
                }
                var data = {
                    otp: otp,
                    email: email
                };
                break;
            case 'email':
                var field = $('#email');
                var email = field.val();
                if (!email) {
                    addError(field, 'Email is required');
                    return false;
                }
                var data = {
                    email: email
                };
                break;
            case 'reset':
                var field = $('#new-password');
                var password = field.val();
                var confirm_password = $('#confirm-password').val();
                var email = $('#email').val();
                if (!password) {
                    addError(field, 'Password is required');
                    return false;
                }
                if (password != confirm_password) {
                    addError(field, 'Password and Confirm Password should be same');
                    return false;
                }
                var data = {
                    email: email,
                    password: password,
                    confirm_password: confirm_password
                };
                break;
        
            default:
                break;
        }
        removeError(field);

        
        data[csrf_name] = $('meta[name="X-CSRF-TOKEN"]').attr('content');
        $.ajax({
            url: url,
            type: type,
            data: data,
            beforeSend: function() {
                processLoader(true);
            },
            success: function(response) {
                processLoader(false);
                updateCsrfTokenInDom(response.token);
                if(response.success) {
                    switch (id) {
                        case 'otp':
                            $('#verifyOtp').addClass('d-none');
                            $('#resetForm').removeClass('d-none');
                            break;
                        case 'email':
                            $('#resetPasswordForm').addClass('d-none');
                            $('#verifyOtp').removeClass('d-none');
                            break;
                        case 'reset':
                            alert(response.message);
                            window.location.href = '/';
                            break;
                    
                        default:
                            break;
                    }
                }else{
                    addError(field, response.message);
                }
            }
        });
        
    });

    function addError(field, message) {
        field.next().removeClass('d-none');
        field.parent().addClass('border border-danger');
        $('.errorMsgDiv').text(message);
    }

    function removeError(field) {
        field.next().addClass('d-none');
        field.parent().removeClass('border border-danger');
        $('.errorMsgDiv').text('');
    }
</script>
<?php print view('site/footer'); ?>