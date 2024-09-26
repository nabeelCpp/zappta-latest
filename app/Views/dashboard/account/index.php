<?php print view('site/header');?>

	<section class="bread">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-12">
					<div class="bb">
						<ul class="p-0 m-0 d-flex align-items-center">
							<li>
								<a href="<?php print base_url();?>">Home</a>
							</li>
							<li>/</li>
							<li>
								<a href="<?php print base_url().'/dashboard';?>"><?php print $pagetitle;?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="dashboard">
		<div class="container">

			<div class=" d-flex">
				<?php print view('dashboard/sidebar');?>
				<!-- Page content holder -->
				<div class="page-content p-5 " id="content">

					<div class="dashboard-page">
						
						<h3><i   onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i>Personal info</h3>
						<div class="errorBlock mt-2 mb-2"><?php print show_message();?></div>
						<div class="account_block mt-4">
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-12">
									<div class="info">
										<h4>Your personal information</h4>
										<div class="class">
											<label>Full name</label>
											<div class="field">
											<?php  if ( !empty($user['fname']) ) { ?>
												<div id="userfname">
													<div class="d-flex align-items-center">
														<div class="field-text" id="fullnameUpdate"><?php print $user['fname'];?></div>
														<button type="button" class="btn p-0 text-end" id="dashEdit">Edit</button>
													</div>
												</div>
												<div id="userupdate">
													<div class="field-input">
														<div>
															<input type="text" id="dashUserName" class="form-control" value="<?php print $user['fname'];?>" placeholder="Add Full name">
														</div>
														<button type="button" class="btn p-0" id="dashUser">Update</button>
													</div>
												</div>
											<?php } else { ?>
												<div id="userupdate" style="display:block !important;">
													<div class="field-input d-flex">
														<div>
															<input type="text" id="dashUserName" class="form-control" placeholder="Add Full name">
														</div>
														<button type="button" class="btn p-0" id="dashUser">Add</button>
													</div>
												</div>
											<?php } ?>
											</div>
										</div>
										<div class="class">
											<label>Email address</label>
											<div class="field email">
												<div id="useremail">
													<div class="d-block">
														<div class="field-text"><?php print $user['email'];?></div>
											<?php  if ( $user['email_verify'] == 1 ) { ?>
														<div class="d-flex align-items-center mt-1">
															<span class="icons"><i class="fa-solid fa-triangle-exclamation"></i></span>
															<span class="texts">For extra security</span>
															<button type="button" class="btn p-0 text-end" id="emailVerify">Verify now</button>
														</div>
											<?php } ?>
													</div>
												</div>
											</div>
										</div>
										<div class="class">
											<label>Phone number</label>
											<div class="field phone">
												<div id="userphone">
													<div class="d-block">
											<?php  if ( !empty($user['phone']) ) { ?>
														<div class="field-text"><?php print $user['phone'];?></div>
											<?php } else { ?>
														<div id="userphone">
															<div class="field-input">
																<div>
																	<input type="text" id="userphone_" class="form-control" placeholder="Add phone number">
																</div>
																<button type="button" class="btn" id="dashPhoneUser" onclick="saveUserPhone(this)">Add</button>
															</div>
														</div>
											<?php } ?>
											<?php  if ( !empty($user['phone']) && $user['phone_verify'] == 1 ) { ?>
														<div class="d-flex">
															<span class="icons"><i class="fa-solid fa-triangle-exclamation"></i></span>
															<span class="texts">For extra security</span>
															<button type="button" class="btn p-0">Verify now</button>
														</div>
											<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-12">
									<div class="info">
										<h4>Sign in preference</h4>
										<div class="class password">
											<div class="pt ps-4 mt-2 mb-2 position-relative">
												Password (Basic security)
											</div>
											<div class="pedit mt-2 mb-2 d-flex" id="userPass">
												<div>*********</div>
												<!-- <button type="button" class="btn p-0" id="passwordEditUser">Edit</button> -->
											</div>
											<form method="POST" onsubmit="renderForm(event, this)" action="<?=base_url('dashboard/account/updatePassword')?>" class="form-inline">
												<input type="hidden" name="<?=csrf_token()?>" value="<?=csrf_hash()?>">
												<label class="sr-only" for="inlineFormInputGroupUsername2">Current Password</label>
												<div class="input-group mb-2 mr-sm-2 password-div">
													<input type="password" required name="current_pass" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Current Password">
													<div class="input-group-prepend">
														<div class="input-group-text show-hide-pass" data-status="0"><i class="fa fa-eye"></i></div>
													</div>
												</div>
												
												
												<label class="sr-only" for="inlineFormInputGroupUsername1">New Password</label>
												<div class="input-group mb-2 mr-sm-2 password-div">
													<input type="password" required class="form-control" name="new_pass" id="inlineFormInputGroupUsername1" placeholder="New Password">
													<div class="input-group-prepend">
														<div class="input-group-text show-hide-pass" data-status="0"><i class="fa fa-eye"></i></div>
													</div>
												</div>
												
												
												<label class="sr-only" for="inlineFormInputGroupUsername3">Confirm Password</label>
												<div class="input-group mb-2 mr-sm-2 password-div">
													<input type="password" required class="form-control" name="confirm_pass" id="inlineFormInputGroupUsername3" placeholder="Confirm Password">
													<div class="input-group-prepend">
														<div class="input-group-text show-hide-pass" data-status="0"><i class="fa fa-eye"></i></div>
													</div>
												</div>
												<button type="submit" class="btn btn-primary" style="background-color: #fd7e14">Update</button>
											</form>
										</div>
									</div>
								</div>
							</div>
							<input type="hidden" id="_profileToken" value="<?php print csrf_hash();?>">
						</div>

					</div>

				</div>
				<!-- End demo content -->
			</div>

		</div>
	</section>
	<script type="text/javascript">
		function saveUserPhone(thiss) {
			let phone = $('#userphone_').val();
			if(!phone.match(/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im)){
				alert('invalid phone number.');
				return false;
			}else{
				$.ajax({
					url: '<?=base_url()?>/dashboard/account/savePhone',
					type: 'POST',
					dataType: 'json',
					data: {
						<?=csrf_token()?>: '<?=csrf_hash()?>',
						phone: phone,
					},
					beforeSend: function(){
						$(thiss).attr('disabled', true);
					},
					success: function(data){
						$(thiss).attr('disabled', false);
						if(data.error){
							alert(data.msg);
						}else{
							window.location.href = '';
						}
					}
				})
			}
		}
	</script>

<?php print view('site/footer');?>
<script>
	$('.show-hide-pass').click(function() {
		let status = parseInt($(this).attr('data-status'));
		if(status == 0){
			status = 1;
			$(this).find('i').removeClass('fa-eye');
			$(this).find('i').addClass('fa-eye-slash');
		}else{
			status = 0;
			$(this).find('i').removeClass('fa-eye-slash');
			$(this).find('i').addClass('fa-eye');
		}
		$(this).attr('data-status', status);
		$(this).parents('.password-div').find('input').attr('type', `${status==1?"text":"password"}`);
	})

	function renderForm(event, element) {
		event.preventDefault();
		let form = $(element);
		let url = form.attr('action');
		let type = form.attr('method');
		let required = form.find('[required]');
		let errors = 0;
		required.each(function(){
			if( !$(this).val() ){
				errors++;
				if(!$(this).hasClass('is-invalid')){
					$(this).addClass('is-invalid');
				}
			}else{
				if($(this).hasClass('is-invalid')){
					$(this).removeClass('is-invalid');
				}
			}
		});
		if(form.find('[name="new_pass"]').val() != form.find('[name="confirm_pass"]').val()){
			notyf.error(`New password and confirm password doesnot match!`);
			errors++;
		}
		if(!errors){
			const data = form.serialize();
			$.ajax({
				url: url,
				type: type,
				dataType: 'json',
				data: data,
				beforeSend: function(){
					form.find('[type="submit"]').attr('disabled', true);
				},
				success: function(response) {
					$('[name="<?=csrf_token()?>"]').val(response._cc);
					$('#_profileToken').val(response._cc);
					form.find('[type="submit"]').attr('disabled', false);
					if(response.success){
						form.find('[name="current_pass"]').val('')
						form.find('[name="new_pass"]').val('')
						form.find('[name="confirm_pass"]').val('')
						notyf.success(response.msg);
					}else{
						notyf.error(response.msg);
					}
				}
			})
		}
		
	}
</script>