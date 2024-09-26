<?= view('site/newLanding/header', ['globalSettings' => $globalSettings, 'css' => $css]); ?>
<style>
  .inner-banner-all {
    height: 370px;
    background-repeat: no-repeat;
    background-color: #ffffff;
    opacity: 1;
    object-fit: cover;
  }

  .inner-banner-all h3 {
    background-color: #ffc72c !important;
    display: inline-block;
    padding: 10px;
    color: #53565a !important;
  }

  .comp-img-card-custom {
    min-height: 150px;
    border: 1px solid lightgrey;
    box-shadow: 3px 3px 10px -8px black;
    margin: 5px 10px !important;
  }

  .logo-img {
    height: 100%;
  }

  .logo-img a {
    height: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-direction: column;
  }

  .lgimg {
    display: flex;
    flex-grow: 1;
    justify-content: center;
    align-items: center;
  }
</style>

<div
  class="inner-banner-all d-flex align-items-center"
  style="background-image: url(/assets/images/management.png); height: 120px;">
  <section class="bread bg-white">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12">
          <div class="bb">
            <ul class="p-0 m-0 d-flex align-items-center">
              <li>
                <a href="<?php print base_url(); ?>">Home</a>
              </li>
              <li>/</li>
              <li>
                <a href="<?php print base_url() . '/stores'; ?>">Stores</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="container text-center">
    <h3 class="p-2 bg-success text-white">
      Explore All Stores In Zappta
    </h3>
  </div>
</div>
<div class="container mb-5">
  <div class="d-flex flex-wrap justify-content-center" style="width: 100%;">

    <?php
    // for($i=1; $i<=10;$i++){
    if (is_array($store) && count($store) > 0) {
      foreach ($store as $st) { ?>
        <div
          class="p-1 my-2 comp-img-card comp-img-card-custom col-md-2">
          <div class="logo-img">
            <a href="<?php print base_url() . '/stores/' . $st['store_slug']; ?>">
              <div class="lgimg">
                <?php
                if (! empty($st['store_logo'])) {
                  $ext_name = explode('.', $st['store_logo']);
                ?>
                  <img
                    src="<?php print base_url() . '/images/media/' . $ext_name[0] . '/' . $ext_name[1] . '/250'; ?>"
                    class="animate img-thumbnail"
                    alt="" style="max-width: 60%" />
                <?php } else { ?>
                  <img
                    src="<?php print base_url() . '/images/media/img-not-found/jpg/100'; ?>"
                    class="animate"
                    alt="" />
                <?php } ?>
              </div>
              <?php if ($st['earn_zappta'] && $st['per_dollar']) { ?>
                <div class="lgztext">
                  <span>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="11"
                      height="24"
                      viewBox="0 0 11 24">
                      <g
                        id="Group_1"
                        data-name="Group 1"
                        transform="translate(-1363 -79)">
                        <text
                          id="Z"
                          transform="translate(1363 98)"
                          fill="#fb5000"
                          font-size="18"
                          font-family="OpenSans, Open Sans">
                          <tspan x="0" y="0">Z</tspan>
                        </text>
                        <g
                          id="Rectangle_4"
                          data-name="Rectangle 4"
                          transform="translate(1367 82)"
                          fill="#fff"
                          stroke="#fb5000"
                          stroke-width="1">
                          <rect width="2" height="4" stroke="none" />
                          <rect x="0.5" y="0.5" width="1" height="3" fill="none" />
                        </g>
                        <g
                          id="Rectangle_5"
                          data-name="Rectangle 5"
                          transform="translate(1367 98)"
                          fill="#fff"
                          stroke="#fb5000"
                          stroke-width="1">
                          <rect width="2" height="4" stroke="none" />
                          <rect x="0.5" y="0.5" width="1" height="3" fill="none" />
                        </g>
                      </g>
                    </svg>
                  </span>
                  <span class="zzf"><?= $st['earn_zappta'] ?>
                    per $<?= $st['per_dollar'] ?></span>
                </div>
              <?php } ?>
            </a>
          </div>
        </div>
    <?php
      }
    }
    ?>

  </div>
</div>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>