<!-- newsletter -->
<?= view('site/newLanding/newsletter') ?>
<footer class="footer-section pt-60">
  <div class="container">
    <div class="row footer-widget-wrap pb-60">
      <div class="col-lg-5 col-md-6">
        <div class="footer-widget">
          <div class="widget-header">
            <a href="<?php print base_url(); ?>">
              <img src="<?= base_url() . '/upload/logo/' . $globalSettings[0]['var_detail'] ?>" alt="Logo" style="width: 150px; height: 100px" />
            </a>
          </div>
          <ul class="schedule-list">
            <li>
              Lorem ipsum dolor sit amet consectetur. Et mus feugiat nec
              proin tristique nulla adipiscing. Semper.
            </li>
            <div class="footer-contact mt-3">

              <img src="<?= $assets_url ?>/img/call-calling.png" alt="" />

              <div class="content">
                <a href="tel:18005707777">1-800-570-7777</a>
              </div>
            </div>
          </ul>
        </div>
      </div>
      <div class="col-lg-2 col-md-6">
        <div class="footer-widget">
          <div class="widget-header">
            <h3 class="widget-title">COMPANY</h3>
          </div>
          <ul class="footer-list">
            <li><a href="<?php print base_url() . '/about-us'; ?>">About Us</a></li>
            <li><a href="<?php print base_url() . '/contact-us'; ?>">Contact Us</a></li>
            <li><a href="<?= getUserId() > 0 ? base_url() . '/dashboard/history' : '#' ?>" <?= getUserId() == 0 ? 'data-bs-toggle="modal" data-bs-target="#accountModal"' : '' ?>>Order History</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-2 col-md-6">
        <div class="footer-widget">
          <div class="widget-header">
            <h3 class="widget-title">MY ACCOUNT</h3>
          </div>
          <ul class="footer-list">
            <li><a href="<?php print base_url() . '/cart'; ?>">View Cart</a></li>
            <li><a href="#" onclick="showLogin('login');">Sign In</a></li>
            <li><a href="<?= base_url() . (getUserId() > 0 ? '/dashboard/help' : '/help') ?>">Help</a></li>
            <li><a href="<?= getUserId() > 0 ? base_url() . '/dashboard/wishlist' : '#' ?>" <?= getUserId() == 0 ? 'data-bs-toggle="modal" data-bs-target="#accountModal"' : '' ?>>Wishlist</a></li>

          </ul>
        </div>
      </div>
      <div class="col-lg-2 col-md-6">
        <div class="footer-widget">
          <div class="widget-header">
            <h3 class="widget-title">CUSTOMER SERVICE</h3>
          </div>
          <ul class="footer-list">
            <li><a href="<?php print base_url() . '/payment-method'; ?>">Payment Methods </a></li>
            <li><a href="<?php print base_url() . '/return-policy'; ?>">Products Returns</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="copyright-area">
    <div class="container">
      <div class="row copyright-content">
        <div class="col-lg-6">
          <div class="footer-img-wrap">
            <span><a href="<?php print base_url() . '/terms-conditions'; ?>">Terms & Conditions</a></span>
            <span><a href="<?php print base_url() . '/privacy-policy'; ?>">Privacy Policy</a></span>
          </div>
        </div>
        <div class="col-lg-6">
          <p>
            <a href="https://web.facebook.com/Zappta-100522449234631" class="m-2" target="_blank">
              <img src="<?= $assets_url ?>/img/fb.png" alt="" /></a>
            <a href="https://twitter.com/Zappta_official" class="m-2" target="_blank">
              <img src="<?= $assets_url ?>/img/twitter.png" alt="" /></a>
            <a href="https://www.youtube.com/channel/UCbulLJCMUctF7AEhH2nVhpQ" class="m-2" target="_blank">
              <img src="<?= $assets_url ?>/img/youtube.png" alt="" /></a>
            <a href="https://www.instagram.com/zappta_official/" class="m-2" target="_blank">
              <img src="<?= $assets_url ?>/img/instagram.png" alt="" /></a>
          </p>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" id="_tt_cc" value="<?php print csrf_hash(); ?>">
</footer>

<?php $refer_user = isset($_GET['refer']) ? $_GET['refer'] : 0;
$playgive = isset($_GET['playgive']) ? $_GET['playgive'] : 0; ?>
<!-- Modal -->


<div class="modal fade signUpModal" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true" style="z-index: 999999;">

  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modalLogo">
        <a href="<?php print base_url(); ?>">
          <img src="<?= base_url() . '/upload/logo/' . $globalSettings[0]['var_detail'] ?>" alt="Logo" style="width: 150px; height: 100px" />
        </a>
      </div>

      <div class="bs-example bs-example-tabs">
        <ul id="myTab" class="nav nav-tabs">
          <li id="login-tab" class=" active tab-style login-shadow "><a type="button" data-toggle="tab">Log In</a></li>
          <li id="signup-tab" class=" tab-style "><a type="button" data-toggle="tab">Sign Up</a></li>
        </ul>
      </div>
      <div class="modal-body">
        <div id="myTabContent" class="tab-content">

          <div class="tab-pane active in" id="nav-login">

            <h2>Welcome to Zappta!</h2>
            <p>Log in to Unleash Adventure!</p>
            <div class="loginSignup-form">
              <div class="fieldset">
                <label class="image-replace cd-email" for="signin-email">Email Address</label>

                <div class="fieldSection">
                  <div class="formIcon"><img src="<?= $assets_url ?>/img/Email.svg" alt="" /></div>
                  <input class="full-width has-padding has-border" name="email" id="userEmail" type="email" placeholder="Enter your Email address">
                </div>

              </div>

              <div class="fieldset">
                <label class="image-replace cd-email" for="signin-email">Password</label>

                <div class="fieldSection">
                  <div class="formIcon"><img src="<?= $assets_url ?>/img/lock.svg" alt="" /></div>
                  <input class="full-width has-padding has-border password-field" name="password" id="userPassword" type="password" placeholder="........">
                  <a type="button" class="hide-password"><img src="<?= $assets_url ?>/img/eye-slash.svg" alt="" /></a>
                  <!-- <span class="cd-error-message">Error message here!</span> -->
                </div>

              </div>



              <div class="fieldset d-flex justify-content-end">
                <a id="forgotPassword" href="<?=route_to('forgot-password')?>">Forgot Password ?</a>
              </div>
              <div class="errorForm text-center"></div>
              <div class="successForm text-center"></div>

              <div class="fieldset mt-4">
                <input type="hidden" id="_user_login_token" value="<?php print csrf_hash() ?>">
                <input class="full-width submitBtn" id="loginBtn" type="submit" value="Login">
              </div>

              <div class="text-center vendorText">
                <p><a href="<?php print base_url() . '/vendor-login'; ?>">Log In as a vendor?</a></p>
              </div>
              <div class="signInBySocial mb-2">
                <a href="<?php print filter_var(google_login_url($refer_user), FILTER_SANITIZE_URL); ?>"><img src="<?= $assets_url ?>/img/google.svg" alt="" /> Sign In with Google</a>
              </div>
              <div class="signInBySocial">
                <a href="<?php print filter_var(facebook($refer_user), FILTER_SANITIZE_URL); ?>" scope="public_profile,email" onlogin="FB.login();">
                  <img src="<?= $assets_url ?>/img/facebook.svg" alt="" /> Sign In with Facebook</a>
              </div>
            </div>
          </div>


          <div class="tab-pane" id="nav-signup">
            <h2>Welcome to Zappta!</h2>
            <p>Sign Up to Unleash Adventure!</p>
            <div class="loginSignup-form">
              <div class="fieldset">
                <label class="image-replace cd-email" for="signin-email">Email Address</label>

                <div class="fieldSection">
                  <div class="formIcon"><img src="assets/img/Email.svg" alt="" /></div>
                  <input class="full-width has-padding has-border" name="userSignEmail" id="userSignEmail" type="email" placeholder="Enter your Email address">
                </div>

              </div>
              <div class="fieldset">
                <label class="image-replace cd-email" for="signin-email">Username</label>
                <div class="fieldSection">
                  <div class="formIcon"><img src="assets/img/user.svg" alt="" /></div>
                  <input class="full-width has-padding has-border" name="userSignusername" id="userSignusername" type="text" placeholder="Enter your username">
                </div>
              </div>
              <div class="fieldset">
                <label class="image-replace cd-email" for="signin-email">Password</label>

                <div class="fieldSection">
                  <div class="formIcon"><img src="assets/img/lock.svg" alt="" /></div>
                  <input class="full-width has-padding has-border password-field" name="userSignPassword" id="userSignPassword" type="password" placeholder="........">
                  <a type="button" class="hide-password"><img src="<?= $assets_url ?>/img/eye-slash.svg" alt="" /></a>
                </div>

              </div>
              <div class="errorForm text-center"></div>
              <div class="successForm text-center"></div>
              <div class="fieldset mt-3">
                <input type="hidden" id="_user_register_token" value="<?php print csrf_hash() ?>">
                <input type="hidden" id="_user_refer_token" value="<?php print $refer_user; ?>">
                <input class="full-width submitBtn mt-2" id="singupbtn" type="button" value="Sign Up">
              </div>

              <div class="text-center vendorText">
                <p><a href="<?php print base_url() . '/vendor-registration'; ?>">Signup as a vendor?</a></p>
              </div>
              <div class="signInBySocial mb-2">
                <a href="<?php print filter_var(google_login_url($refer_user), FILTER_SANITIZE_URL); ?>"><img src="<?= $assets_url ?>/img/google.svg" alt="" /> Sign Up with Google</a>
              </div>
              <div class="signInBySocial">
                <a href="<?php print filter_var(facebook($refer_user), FILTER_SANITIZE_URL); ?>" scope="public_profile,email" onlogin="FB.login();">
                  <img src="<?= $assets_url ?>/img/facebook.svg" alt="" /> Sign Up with Facebook</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--<div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </center>
      </div>-->
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="showReferLogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-body">
        <div class="loginpopform">
          <div class="lg-form-close text-end position-relative">
            <button type="button" style="right:20px" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="lg-form-head">
            <img src="<?= base_url() . '/upload/logo/' . $globalSettings[0]['var_detail'] ?>" alt="" />
          </div>
          <div class="lg-form-tabs">
            <div class="lg-form-field">
              <!-- <div class="form-group position-relative">
				  				<label class="position-absolute"><i class="far fa-smile"></i></label>
				  				<input type="text" name="friendname" id="friendName" placeholder="Name ( * )" />
				  			</div>
				  			<div class="form-group position-relative">
				  				<label class="position-absolute"><i class="fa-solid fa-envelope"></i></label>
				  				<input type="text" name="friendemail" id="friendEmail" placeholder="your@example.com ( * )" />
				  			</div>
				  			<div class="form-group position-relative">
				  				<label class="position-absolute"><i class="fas fa-comment-alt"></i></label>
				  				<input type="text" name="friendmsg" id="friendMsg" placeholder="Your Message ( * )" />
				  			</div>
				  			<div class="errorForm position-relative"></div>
				  			<div class="successForm position-relative"></div>
				  			<div class="form-group-btn">
             			<input type="hidden" id="_user_login_token" value="<?php print csrf_hash() ?>">
				  				<button type="button" class="btn popuplgbtn" id="frindBtn">Send Request</button>
				  			</div> -->


              <style>
                .social-media {
                  display: flex;
                  flex-direction: column;
                  justify-content: center;
                  align-items: center;
                }

                .social-media .share-icon-div i {
                  font-size: 30px;
                  margin-right: 20px;

                }

                .social-media .share-icon-div {
                  display: flex;
                  align-items: center;
                  margin-bottom: 20px;
                  border-radius: 15px !important;
                  width: 80%;
                }

                @media only screen and (max-width: 575px) {
                  .social-media .share-icon-div {
                    width: 100%;

                  }
                }
              </style>

              <?php if (getUserId()) {
                $referral_link = base_url() . '/signup/' . my_encrypt(getUserId()); ?>
                <div class="social-media">
                  <div class="share-icon-div btn btn-primary" style="background: #3B5998 !important"><i class="fa-brands fa-facebook"></i><a href="http://www.facebook.com/sharer.php?u=<?= $referral_link ?>" target="__blank" onclick="addZaptaCoins('facebook')" style="color: white">Share on facebook</a> </div>
                  <div class="share-icon-div btn btn-primary" style="background: #00acee;"><i class="fa-brands fa-twitter"></i><a style="color: white" target="__blank" href="http://twitter.com/share?text=Join zappta via my referal link! &url=<?= $referral_link ?>&hashtags=Zappta,Join Zappta,Referral Link" onclick="addZaptaCoins('twitter')">Share on twitter</a></div>
                  <div class="share-icon-div btn btn-success" style="background: #075e54"><i class="fa-brands fa-whatsapp"></i><a href="https://wa.me/send?text=Here is my referall Link to join zappta. <?= $referral_link ?>" target="__blank" style="color: white" onclick="addZaptaCoins('whatsapp')">Share on whatsapp</a></div>
                  <div class="share-icon-div btn btn-danger" style="background: #c8232c"><i class="fa-brands fa-pinterest"></i><a style="color: white;" target="__blank" href="http://pinterest.com/pin/create/button/?url=<?= $referral_link ?>" onclick="addZaptaCoins('pinterest')">Share on pinterest</a></div>
                  <div class="share-icon-div btn btn-light" style="background: #1f3541;"><i class="fa fa-envelope" style="color: white"></i><a href="mailto:?Subject=My Zappta referall link!&Body=My referall link is <?= $referral_link ?>" target="__blank" style="color: white" onclick="addZaptaCoins('email')">Share on Email</a></div>
                  <div class="share-icon-div btn btn-light" style="background: orangered;" id="copy_to_clipboard"><i class="fa fa-copy" style="color: white"></i><a data-href="<?= $referral_link ?>" style="color: white">Copy</a></div>
                </div>
              <?php } ?>

            </div>
          </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="askQuestion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-body">
        <div class="loginpopform">
          <div class="lg-form-close text-end position-relative">
            <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="lg-form-head">
            <img src="<?= base_url() . '/upload/logo/' . $globalSettings[0]['var_detail'] ?>" alt="" />
          </div>
          <div class="lg-form-tabs">
            <div class="lg-form-field">
              <div class="form-group position-relative">
                <textarea class="form-control" id="askQuestionDetail" placeholder="Question ( * )"></textarea>
              </div>
              <div class="errorForm position-relative"></div>
              <div class="successForm position-relative"></div>
              <div class="form-group-btn">
                <input type="hidden" id="_user_ask_question" value="<?php print csrf_hash() ?>">
                <button type="button" class="btn popuplgbtn" id="askQuestionBtn">Send</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

<div id="scroll-percentage"><span id="scroll-percentage-value"></span></div>
<!--scrollup-->
</div>
<!-- JS here -->
 <script src="<?= base_url('minified/js/scripts-1.0.31.min.js')?>"></script>


<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script>
  // Create an instance of Notyf
  var notyf = new Notyf({
    duration: 10000,
    ripple: true,
    dismissible: true,

  });
</script>
<?php
$refer_user = isset($_GET['refer']) ? $_GET['refer'] : 0;
$playgive = isset($_GET['playgive']) ? $_GET['playgive'] : 0;
if ($refer_user !== 0 && getUserId() == 0) {
?>
  <script type="text/javascript">
    $(function() {
      showLogin('singin');
    })
  </script>
<?php
}
if ($playgive !== 0 && getUserId() == 0) {
?>
  <script type="text/javascript">
    $(function() {
      showLogin('singin');
      $("#canvas").outerHeight($(window).height() - $("#canvas").offset().top - Math.abs($("#canvas").outerHeight(true) - $("#canvas").outerHeight()));
      $(window).on("resize", function() {
        $("#canvas").outerHeight($(window).height() - $("#canvas").offset().top - Math.abs($("#canvas").outerHeight(true) - $("#canvas").outerHeight()));
      });
    })
  </script>
<?php
}
if ($playgive !== 0) {
?>

<?php } ?>
<script>
  $('#copy_to_clipboard').click(function(e) {
    e.preventDefault();
    let a = $(this).find('a');
    let url = a.data('href');
    // a.select();
    // a.setSelectionRange(0, 99999); // For mobile devices

    // Copy the text inside the text field
    navigator.clipboard.writeText(url);
    a.text('Copied to clipboard!');
    setTimeout(() => {
      a.text('Copy');
    }, 3000);

  })

  $('#join_now_newsletter').click(function() {
    let input = $('#footernews').val();
    $(this).attr('disabled', true);
    if (!input) {
      return false;
    }
    setTimeout(() => {
      $('#newsletter_alert').removeClass('d-none');
    }, 3000);
    setTimeout(() => {
      $('#newsletter_alert').addClass('d-none');
    }, 6000);
  });

  function addZaptaCoins(sm) {
    $.ajax({
      url: '<?= base_url() ?>/api/socialMediaZapptas',
      type: 'POST',
      dataType: 'json',
      data: {
        social_media: sm,
      },
      success: function(res) {
        $('#userTotalZappta').find('a').text(res.balance);
      }
    })
  }
  localStorage.setItem('csrf', '<?= csrf_hash() ?>');
  <?php if (getUserId() > 0) { ?>
    let idle = false;
    $(document).on('click', '.upcoming_select_store', function() {
      let url = $(this).attr('data-url');
      let id = $(this).attr('data-id');
      let com = $(this).attr('data-comp');
      let btn = $(this);
      localStorage.setItem('store_url', url);
      localStorage.setItem('store_id', id);
      localStorage.setItem('com_id', com);
      localStorage.setItem('timer', 0);
      console.log($(this).attr('data-button'));
      if ($(this).attr('data-button') && $(this).attr('data-button') == 'play') {
        btn.text('Checking...');
        btn.attr('disabled', true);
        $.ajax({
          url: '<?= base_url() ?>/home/fetchSpree',
          data: {
            store_id: localStorage.store_id,
            com_id: localStorage.com_id,
            <?= csrf_token() ?>: localStorage.csrf
          },
          type: 'POST',
          dataType: 'json',
          success: function(data) {
            btn.text('PLAY NOW');
            btn.attr('disabled', false);
            if (data.token) {
              localStorage.setItem('csrf', data.token);
            }
            if (data.spree.length > 0) {
              window.location.href = url;
            } else {
              let button = `<button type="button" 
							data-url="${btn.attr('data-href')}" data-id="${id}" data-comp="${com}" class="btn btn-sm btn-light upcoming_select_store" >Click Here</button>`
              notyf.error(`You have no items selected for spree. ${button} to select items!`);
            }
          }
        })
      } else {
        window.location.href = url;
      }
    });
    var timer = setTimeout(() => {
      idle = true;
    }, 5000);
    $('html').bind("mousemove keypress keyup keydown change", function(e) {
      idle = false;
      clearTimeout(timer);
      timer = setTimeout(() => {
        idle = true;
      }, 25000);
    });

    function addSpreeGalaToStore(data, sprees) {
      let section = $('#bannerSectionGala');
      console.log(data);
      let html = `<div class="row justify-content-end mx-5">
						<div class="col-12">
							<div class="periodic_timer_minutes_1 card px-3 py-1">
								<div class="card-header">
									<h6 class="text-center mb-1">Game ${new Date(data.compain_s_date) > new Date()?'Starts': 'Ends'} in</h6>
								</div>
								<div class="body">
									<div class="countdown show d_5" data-date="${new Date(data.compain_s_date) > new Date()?data.compain_s_date: data.compain_e_date+" 11:59:59"}">
										<div class="running" style="display: flex;">
											<timer class="align-items-center">
												<span class="timerspan">
													<span class="days">00</span>
													<span class="timerlabel">Days</span>
												</span>	
												<span class="timerdots">:</span>
												<span class="timerspan">
													<span class="hours">00</span>
													<span class="timerlabel">Hrs</span>
												</span>	
												<span class="timerdots">:</span>
												<span class="timerspan">
													<span class="minutes">00</span>
													<span class="timerlabel">Mins</span>
												</span>	
												<span class="timerdots">:</span>
												<span class="timerspan">
													<span class="seconds">00</span>
													<span class="timerlabel">Secs</span>
												</span>	
											</timer>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>`;
      let style = section.attr('style');
      // let arr = style.split(": ");
      // let last = arr.pop();
      // arr.push(":linear-gradient(to top, #e8eaebba, #404040cc),");
      // arr.push(last);
      // section.attr('style', arr.join(""));
      section.html(html);

      let newGala = $('#newGalaDetails');
      let newHtml = `<div class="col-md-6 col-lg-6 col-sm-12">
					<div class="card p-5 border border-danger">
						<div class="card-body text-center">
							${!sprees?`<p class="h5"><b>Your Okanui Spin to Win Cart is empty</b></p>`:''}
							<p class="mt-1">Browse our entire store now to select the products you want to win. We pay <span style="color: #FB5000">5 zapptas</span> per minute you spend selecting your products. Cha-ching!</p>
							<p class="mt-3">Your selected products will appear here. <span><a href="<?= base_url('dashboard/spree') ?>" class="btn btn-link">Start browsing</a></span></p>
							<div class="d-flex justify-content-center">
								<div class="periodic_timer_minutes_2 w-75 card">
									<h6 class="text-center mb-1 card-header">Game ${new Date(data.compain_s_date) > new Date()?"Starts": "Ends"} in</h6>
									<div class="countdown show d_5 card-body" data-date="${new Date(data.compain_s_date) > new Date()?data.compain_s_date: data.compain_e_date+" 11:59:59"}">
										<div class="running" style="display: flex;">
											<timer class="align-items-center">
												<span class="timerspan">
													<span class="days">00</span>
													<span class="timerlabel">Days</span>
												</span>	
												<span class="timerdots">:</span>
												<span class="timerspan">
													<span class="hours">00</span>
													<span class="timerlabel">Hrs</span>
												</span>	
												<span class="timerdots">:</span>
												<span class="timerspan">
													<span class="minutes">00</span>
													<span class="timerlabel">Mins</span>
												</span>	
												<span class="timerdots">:</span>
												<span class="timerspan">
													<span class="seconds">00</span>
													<span class="timerlabel">Secs</span>
												</span>	
											</timer>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-6 col-sm-12">
					<div class="p-5 mt-5 mb-5 flipGala" data-status="1">
						<h1 class="text-center" style="font-size: xxx-large; font-weight: bolder"><b><?= isset($store_id['store_name']) ? $store_id['store_name'] : '' ?></b></h1>
					</div>
					<div class="d-none flipGala" data-status="0">

						<p><b>GO AHEAD, SHOP WITHOUT SPENDING A DIME:</b>Fill your SpinCart with $${data.price} worth of any products you crave from our entire store—then Spin ’Til You Win them all</p>
						<p class="border border-warning px-3 mt-4" style="border-radius: 15px !important">Earn Free Zapptas Now for Making Your Selection! We Pay
									
						<svg xmlns="http://www.w3.org/2000/svg" width="11" height="24" viewBox="0 0 11 24">
							<g id="Group_1" data-name="Group 1" transform="translate(-1363 -79)">
								<text id="Z" transform="translate(1363 98)" fill="#fb5000" font-size="18" font-family="OpenSans, Open Sans"><tspan x="0" y="0">Z</tspan></text>
										    <g id="Rectangle_4" data-name="Rectangle 4" transform="translate(1367 82)" fill="#fff" stroke="#fb5000" stroke-width="1">
												<rect width="2" height="4" stroke="none"/>
												<rect x="0.5" y="0.5" width="1" height="3" fill="none"/>
										    </g>
										    <g id="Rectangle_5" data-name="Rectangle 5" transform="translate(1367 98)" fill="#fff" stroke="#fb5000" stroke-width="1">
										      <rect width="2" height="4" stroke="none"/>
										      <rect x="0.5" y="0.5" width="1" height="3" fill="none"/>
										    </g>
										</g>
									</svg> 5 per minute just for selecting the products you want to win
								</p>
								<div class="bg-light px-4 ">
									<p class="mt-2">
							<b>Have loads of FUN and WIN too, all FREE—</b>no purchase necessary:
						</p>
						<p class="mb-3">
							Get ready to spin your way into $500 worth of amazing
							products! Select the items you want, then rev up those reels
							for a chance to win all your selected items. Hold the top score
							on the leaderboard before timer hits 0:00 and take home
							everything for free - no strings attached!
						</p>
						<p>
							<b>WANT AN UNFAIR ADVANTAGE AGAINST YOUR
								OPPONENTS?</b> Bulk up on coins now and amp up those
								spinning wheels. Don't let yourself miss out on any of the fun -
								collect as many zappta coins as you can and gain the ultimate
								unfair advantage over your opponents!
							</p>
						</div>
					</div>
					<div class="text-center">
						<a href="#storesProList" class="btn btn-link">Select products now and earn coins</a>
					</div>
				</div>`;
      newGala.html(newHtml);
      countdownSpreesTimer();
      let mouseenter = false;
      setInterval(() => {
        if (!mouseenter) {
          let flipGala = $('.flipGala');
          flipGala.each(function() {
            if (parseInt($(this).attr('data-status')) == 1) {
              $(this).addClass('d-none');
              $(this).attr('data-status', 0);
            } else if (parseInt($(this).attr('data-status')) == 0) {
              $(this).removeClass('d-none');
              $(this).attr('data-status', 1);
            }
          })
        }
      }, 4000);
      $(document).on('mouseenter', '.flipGala', function() {
        mouseenter = true;
      })
      $(document).on('mouseleave', '.flipGala', function() {
        mouseenter = false;
      })
    }
    if (localStorage.store_url && currentUrl == localStorage.store_url) {
      fetchSprees();
      addSpreeButtons();


      const localStorageInterval = setInterval(function() {
        if (!idle) {
          let timer = localStorage.timer;
          if (isNaN(timer)) {
            localStorage.removeItem('timer');
            localStorage.removeItem('store_url');
            localStorage.removeItem('store_id');
            localStorage.removeItem('com_id');
            clearInterval(localStorageInterval);
            if (!$('#remained_on_store_page_timer').parents('.carticon').hasClass('d-none')) {
              $('#remained_on_store_page_timer').parents('.carticon').addClass('d-none');
            }
            return false;
          }
          timer++;
          localStorage.setItem('timer', timer);
          let hours = Math.floor(timer / 60);
          let minutes = timer % 60;
          $('#remained_on_store_page_timer').html(('0' + hours).slice(-2) + ":" + ('0' + minutes).slice(-2));
          if ($('#remained_on_store_page_timer').parents('.carticon').hasClass('d-none')) {
            $('#remained_on_store_page_timer').parents('.carticon').removeClass('d-none');
          }
        }
      }, 1000)

    } else {
      if (localStorage.store_url) {
        if ((localStorage.timer / 60).toFixed() > 0) {
          $.ajax({
            url: '<?= base_url() ?>/dashboard/wallet/saveZapptas',
            data: {
              minutes: (localStorage.timer / 60).toFixed(),
              store_url: localStorage.store_url,
              <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            type: 'POST',
            success: function(data) {
              $('#userTotalZappta').find('a').text(parseInt(data.zapptas).toFixed(2));
            }
          })
        }
        localStorage.removeItem('store_url');
        localStorage.removeItem('store_id');
        localStorage.removeItem('timer');
        localStorage.removeItem('com_id');
      }
    }
  <?php } else { ?>
    localStorage.removeItem('store_url');
    localStorage.removeItem('store_id');
    localStorage.removeItem('timer');
    localStorage.removeItem('com_id');
  <?php } ?>

  function addSpreeButtons() {
    let products = $('.pro-detail');
    products.each(function() {
      let btn = $(this).find('.add_To_Spree');
      let html = `<button type="button" class="btn btn-dark btn-sm" data-status='add'>Add to Spin Cart</button>`;
      btn.html(html);
    });
    $('#spreeOptBtn').html(`<button type="button" class="btn btn-dark btn-sm" data-status='add'>Add to Spin Cart</button>`);
  }

  function fetchSprees() {
    $.ajax({
      url: '<?= base_url() ?>/home/fetchSpree',
      type: 'POST',
      dataType: 'json',
      data: {
        store_id: localStorage.store_id,
        com_id: localStorage.com_id,
        <?= csrf_token() ?>: localStorage.csrf
      },
      success: function(res) {
        if (res.token) {
          localStorage.setItem('csrf', res.token);
        }
        if (res.spree) {
          res.spree.forEach(sp => {
            let spree = $(`.add_To_Spree[data-id="${sp.pid}"]`);
            spree.find('button').removeClass('btn-dark');
            spree.find('button').addClass('btn-danger');
            spree.find('button').text('Remove');
            spree.find('button').attr('data-status', 'remove');
            $('#spreeOptBtn[data-id="' + sp.pid + '"]').find('button').removeClass('btn-dark');
            $('#spreeOptBtn[data-id="' + sp.pid + '"]').find('button').addClass('btn-danger');
            $('#spreeOptBtn[data-id="' + sp.pid + '"]').find('button').text('Remove');
            $('#spreeOptBtn[data-id="' + sp.pid + '"]').attr('data-status', 'remove');
          })
        }
        if (res.spreeDetail) {
          addSpreeGalaToStore(res.spreeDetail, res.spree ? res.spree.length : 0);
        }
      }
    });
  }

  $('.add_To_Spree button').click(function(e) {
    e.preventDefault();
    let btn = $(this);
    let pid = btn.parent().data('id');
    let status = btn.attr('data-status');
    const data = {
      store_id: localStorage.store_id,
      com_id: localStorage.com_id,
      pid: pid,
      status: status,
      <?= csrf_token() ?>: localStorage.csrf
    };
    $.ajax({
      url: '<?= base_url() ?>/home/spree',
      type: 'POST',
      dataType: 'json',
      beforeSend: function() {
        btn.parents('.pro-list').css('opacity', '0.4');
        btn.parents('.pro-list').css('pointer-events', 'none');
        $('#spreeOptBtn').css('opacity', '0.4')
        $('#spreeOptBtn').css('pointer-events', 'none')
      },
      data: data,
      success: function(res) {
        if (res.token) {
          localStorage.setItem('csrf', res.token);
        }
        if (res.status) {
          if (res.spree) {
            btn.removeClass('btn-dark');
            btn.addClass('btn-danger');
            btn.text('Remove')
            btn.attr('data-status', 'remove');
            notyf.success(`Product added successfully to spin to win cart. <a href="<?= base_url('dashboard/spree') ?>"><b>Click here</b></a> to view your selected items.`);
          } else {
            btn.removeClass('btn-danger');
            btn.addClass('btn-dark');
            btn.text('Add to Spin Cart');
            btn.attr('data-status', 'add');
            notyf.error("Product removed from spin to win cart.");
          }
        }
        if (!res.status) {
          notyf.error(res.msg);
        }
        btn.parents('.pro-list').removeAttr('style');
        $('#spreeOptBtn').removeAttr('style')
      }
    });
  });

  $('.hide-password').click(function() {
    let parent = $(this).parent();
    const types = ['password', 'text'];
    let passwordField = parent.find('.password-field');
    let type = passwordField.attr('type');
    let newType = types.filter(t => t !== type);
    passwordField.attr('type', newType[0] ?? types[0]);
  })
</script>
</body>

</html>