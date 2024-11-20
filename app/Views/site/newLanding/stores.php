<section class="ampSection pb-100 py-5">
  <div class="container">
    <div class="category-top text-center mb-3">
      <div class="section-heading mb-0">
        <h3 class="section-title">Amp Up Your Winning Power</h3>
        <p>
          Earn free Zapptas (coins to spin the wheel) for every minute you
          browse products.
        </p>
        <a href="<?= base_url() ?>stores" class="btn btn-link zappta-red-color">See All</a>
      </div>

    </div>
    <div class="clientLogos">
      <?php foreach ($store as $key => $st) { ?>
        <div class="logoItem" onclick="location.href='<?php print base_url() . 'stores/' . $st['store_slug']; ?>'">
          <div class="shop-thumb text-center">
            <img src="<?= $st['store_logo'] ?>" class="img img-responsive" alt="">
          </div>
          <div class="text-center">
            <span class="text-success"><?= $st['earn_zappta'] && $st['per_dollar'] ? '+'.$st['earn_zappta'].' Zapptas / $'.$st['per_dollar'] : '' ?></span>
          </div>
        </div>
      <?php } ?>

    </div>

  </div>
</section>