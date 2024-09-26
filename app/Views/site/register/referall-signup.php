<?php print view('site/header');?>
    <div class="container">
        <div class="modal-content mb-4">
            <div class="modal-body">
                <div class="loginpopform">
                   
                    <div class="lg-form-head">
                        <img src="<?php print base_url();?>/theme/image/footer-logo.png" alt="" /><br>
                        <div class="text-center">Referred by : <b><?=$username?></b></div>
                    </div>
                    <div class="lg-form-tabs">
                        
                        <div class="tab-content">
                        
                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="nav-signup-tab">
                            <form action="<?=base_url()?>/register/save" method="POST" id="referall_form">    
                                <div class="lg-form-field">
                                    <div class="form-group position-relative">
                                        <label class="position-absolute"><i class="fa-solid fa-envelope"></i><span style="color: crimson">*</span></label>
                                        <input type="text" name="userSignEmail" required placeholder="Email" value="<?=old('userSignEmail')?>" />
                                    </div>
                                    <div class="form-group position-relative">
                                        <label class="position-absolute"><i class="fa-solid fa-envelope"></i><span style="color:crimson">*</span></label>
                                        <input type="text" name="userSignusername" required placeholder="Username"  value="<?=old('userSignusername')?>" />
                                    </div>
                                    <div class="form-group position-relative">
                                        <label class="position-absolute"><i class="fa-solid fa-lock"></i><span style="color:crimson">*</span></label>
                                        <input type="password" name="userSignPassword" required placeholder="your password" />
                                    </div>
                                    <div class="form-group-text text-center mt-3">
                                        <p class="text-center cstpad">By creating an account, you agree to our <a href="">Terms of Service</a> and <a href="">Privacy & Cookie Statement.</a></p>
                                    </div>
                                    <div class="errorForm position-relative" style="color: crimson; font-size:x-small"><?=session()->getFlashdata('error')?session()->getFlashdata('error'):''?></div>
                                    <div class="successForm position-relative"></div>
                                    <div class="form-group-btn">
                                <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>">
                                <input type="hidden" name="user_refer" value="<?=my_encrypt($id)?>">
                                        <input type="submit" class="btn popuplgbtn" id="referall_form_btn" value="Sign Up">
                                    </div>
                                </div>
                            </form>
                        </div>
                        </div>
    
                    </div>
                </div>
            </div>

        </div>
        
    </div>
<?php print view('site/footer');?>
<script>
    $('#referall_form_btn').click(function(e){
        let form = $('#referall_form');
        let required = form.find('[required]');
        let errors = 0;
        required.each(function(){
            if(!$(this).val()){
                errors++;
            }
        });
        if(errors){
            form.find('.errorForm').html('Fill all required fields to signup!');
            setTimeout(() => {
                form.find('.errorForm').html('');
            }, 5000);
            e.preventDefault();
        }
    })
    $(document).ready(function(){
        setTimeout(() => {
            $('#referall_form').find('.errorForm').html('');
        }, 5000);
    })
</script>