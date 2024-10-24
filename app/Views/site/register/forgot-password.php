<?php print view('site/header'); ?>
<section class="py-5">
    <div class="container">
        <div class="resetPasswordSection">
            <div class="modalLogo">
                <a href="<?=base_url()?>"><img src="<?= base_url() . '/upload/logo/' . $globalSettings[0]['var_detail'] ?>" class="img img-responsive w-25" alt="Logo" /></a>
            </div>
            <h2>Reset Password</h2>
            <form class="loginSignup-form">
                <div class="fieldset mb-3">
                    <label class="image-replace cd-email" for="signin-email">New Password</label>

                    <div class="fieldSection">
                        <div class="formIcon"><img src="assets/img/lock.svg" alt="" /></div>
                        <input class="full-width has-padding has-border" id="signin-password" type="password" placeholder="........">
                        <a href="#0" class="hide-password"><img src="assets/img/eye-slash.svg" alt="" /></a>
                        <span class="cd-error-message">Error message here!</span>
                    </div>

                </div>

                <div class="fieldset">
                    <label class="image-replace cd-email" for="signin-email">Confirm Password</label>

                    <div class="fieldSection">
                        <div class="formIcon"><img src="assets/img/lock.svg" alt="" /></div>
                        <input class="full-width has-padding has-border" id="signin-password" type="password" placeholder="........">
                        <a href="#0" class="hide-password"><img src="assets/img/eye-slash.svg" alt="" /></a>
                        <span class="cd-error-message">Error message here!</span>
                    </div>

                </div>



                <div class="fieldset mt-5">
                    <input class="full-width submitBtn" type="submit" value="Submit">
                </div>



            </form>
        </div>
    </div>
</section>
<?php print view('site/footer'); ?>