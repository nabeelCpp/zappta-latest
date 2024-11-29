<?php
  echo view('site/newLanding/header', ['globalSettings' => $globalSettings]);
?>


<!-- /.Main Header -->
<!-- ./ hero-section start -->

<?= view('site/newLanding/slider') ?>
<!-- ./ hero-section end-->

<!-- how you win -->
<section class="win-section bg-grey">
  <div class="container">
    <div class="section-heading text-center">
      <h2 class="section-title">HOW YOU WIN</h2>
      <p>Easy as 1-2-3...</p>
    </div>
    <div class="row gy-lg-0 gy-4">
      <div class="col-lg-4 col-md-4">
        <div class="team-item">
          <div class="team-thumb">
            <div class="d-flex justify-content-center align-items-center">
              <img
                src="<?= $assets_url ?>/img/1.png"
                alt="img"
                class="img img-responsive w-25 h-50" />
              <div class="zappta-circle align-items-center text-center p-1">
                <h4 class="text-center mt-5">FILL CART!</h4>
                <p>
                  Pick any store and add
                  your favorite must-haves to your cart.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="team-item">
          <div class="team-thumb">
            <div class="d-flex justify-content-center align-items-center">
              <img
                src="<?= $assets_url ?>/img/2.png"
                alt="img"
                class="img img-responsive w-40" />
              <div class="zappta-circle align-items-center text-center p-1">
                <h4 class="text-center mt-5">SPIN!</h4>
                <p>Hold the top score as the timer strikes 0:00—</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="team-item">
          <div class="team-thumb">
            <div class="d-flex justify-content-center align-items-center">
              <img
                src="<?= $assets_url ?>/img/3.png"
                alt="img"
                class="img img-responsive w-40" />
              <div class="zappta-circle align-items-center text-center p-1">
                <h4 class="text-center mt-5">WIN!</h4>
                <p>
                  Everything in your cart is yours—100% FREE, with free shipping, too!
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <p class="text-center textWinClr mt-3">
      <span>Didn’t Win?</span> No biggie! Fill your cart, spin again—no limits.
      More fun, more wins!
    </p>
  </div>
</section>
<!-- WHY FREE? -->
<?php /* <section class="whyFree-section">
  <div class="container">
    <div class="section-heading text-center">
      <h2 class="section-title zappta-red-color">WHY FREE?</h2>
    </div>
    <div class="row gy-lg-0 gy-4">
      <div class="col-lg-4 col-md-4">
        <div class="team-item">
          <div class="team-thumb">
            <img
              src="<?= $assets_url ?>/img/rewards.svg"
              class="img img-responsive"
              alt="img" />
          </div>
          <div class="team-content text-center px-5 mx-3">
            <h3 class="title">Your Playtime Boosts Brand Value</h3>
            <p>
              Brands gain far more value from your Spin to Win engagement, likes, and product views.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="team-item">
          <div class="team-thumb">
            <img
              src="<?= $assets_url ?>/img/costly_ads.svg"
              class="img img-responsive"
              alt="img" />
          </div>
          <div class="team-content text-center px-5 mx-3">
            <h3 class="title">Brands Save Big On Costly Ads</h3>
            <p>
              By playing, you help them save big. Let’s be honest—who watches ads anymore?
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="team-item">
          <div class="team-thumb">
            <img
              src="<?= $assets_url ?>/img/playtime.svg"
              class="img img-responsive"
              alt="img" />
          </div>
          <div class="team-content text-center px-5 mx-3">
            <h3 class="title">Their Savings, Your Rewards</h3>
            <p>
              Fill your cart with whatever you love and spin to win it — all free. Your dream home awaits!
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> */ ?>

<?= view('site/newLanding/campaigns') ?>

<!-- ./ Amp Up Your Winning Power -->

<?= view('site/newLanding/stores') ?>
<!-- Discover Trending Categories -->
<?= view('site/newLanding/categories') ?>




<!-- ./ blog-section -->
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>
<!-- ./ footer-section -->