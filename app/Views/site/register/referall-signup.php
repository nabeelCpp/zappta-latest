<?php print view('site/header'); ?>
<section class="py-5">
    <div class="container">
        <div class="resetPasswordSection">
            <div class="modalLogo">
                <a href="<?= base_url() ?>"><img src="<?= base_url() . '/upload/logo/' . $globalSettings[0]['var_detail'] ?>" class="img img-responsive w-25" alt="Logo" /></a>
            </div>
            <div class="text-center">Referred by : <b><?= $username ?></b></div>
            <form class="loginSignup-form" action="<?= base_url() ?>/register/save" method="POST" id="referall_form">
                <div class="fieldset mb-3">
                    <label class="image-replace cd-email" for="signin-email">Email *</label>

                    <div class="fieldSection">
                        <div class="formIcon"><img src="<?= $assets_url ?>/img/lock.svg" alt="" /></div>
                        <input type="text" name="userSignEmail" class="full-width has-padding has-border" required placeholder="Email" value="<?= old('userSignEmail') ?>" />
                    </div>

                </div>

                <div class="fieldset mb-3">
                    <label class="image-replace cd-email" for="signin-username">Username *</label>

                    <div class="fieldSection">
                        <div class="formIcon"><img src="<?= $assets_url ?>/img/lock.svg" alt="" /></div>
                        <input type="text" name="userSignusername" class="full-width has-padding has-border" required placeholder="Username" value="<?= old('userSignusername') ?>" />
                    </div>
                </div>


                <div class="fieldset">
                    <label class="image-replace cd-email" for="signin-email">Password *</label>

                    <div class="fieldSection">
                        <div class="formIcon"><img src="<?= $assets_url ?>/img/lock.svg" alt="" /></div>
                        <input type="password" name="userSignPassword" class="full-width has-padding has-border" id="signin-password" required placeholder="your password" />
                        <a href="#0" class="hide-password"><img src="<?= $assets_url ?>/img/eye-slash.svg" alt="" /></a>
                    </div>

                </div>

                <small class="text-danger errorForm mt-5"><?= session()->getFlashdata('error') ? session()->getFlashdata('error') : '' ?></small>
                <div class="successForm text-success mt-5"></div>
                <div class="fieldset mt-5">
                    <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" id="__csrf_token">
                    <input type="hidden" name="user_refer" value="<?= my_encrypt($id) ?>">
                    <input class="full-width submitBtn" type="submit" id="referall_form_btn" value="Signup">
                </div>



            </form>
        </div>
    </div>
</section>

<?php print view('site/footer'); ?>
<script>
    $('#referall_form_btn').click(function(e) {
        let form = $('#referall_form');
        let required = form.find('[required]');
        let errors = 0;
        required.each(function() {
            if (!$(this).val()) {
                errors++;
            }
        });
        if (errors) {
            form.find('.errorForm').html('Fill all required fields to signup!');
            setTimeout(() => {
                form.find('.errorForm').html('');
            }, 5000);
            e.preventDefault();
        }
    })
    $(document).ready(function() {
        setTimeout(() => {
            $('#referall_form').find('.errorForm').html('');
        }, 5000);
    });

    $('#referall_form').submit(function(e) {
        e.preventDefault();
        let loader = $('.loader');
        loader.show();
        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize();
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.code == 2) {
                    form.find('.successForm').html(response.msg);
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 2000);
                } else {
                    form.find('#__csrf_token').val(response.token);
                    form.find('.errorForm').html(response.msg);
                    setTimeout(() => {
                        form.find('.errorForm').html('');
                    }, 5000);
                }
                loader.hide();
            },
            error: function(err) {
                form.find('.errorForm').html('Something went wrong, please try again later!');
                setTimeout(() => {
                    form.find('.errorForm').html('');
                }, 5000);
                loader.hide();
            }
        });
    });
</script>