<?= view('site/newLanding/header', ['globalSettings' => $globalSettings]); ?>
<section class="ampSection pb-100 py-5 ampCleints">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-8">
        <h2>Amp Up Your Winning Power</h2>
        <p>Earn free Zapptas (coins to spin the wheel) for every minute you browse products.</p>
      </div>
      <div class="col-12 col-lg-4 ">
        <div class="sidebarCollapse">
          <div class="category-form-wrap m-0">

            <input class="form-control" type="text" name="search" placeholder="Search...">
            <input type="submit" class="searchIcon" />

          </div>
        </div>

      </div>

    </div>

    <div class="clientLogos">
      <?php foreach ($store as $st) { ?>
        <a href="<?=base_url().'/stores/'.$st['store_slug']?>" class="logoItem">
          <div class="shop-thumb text-center" style="height: auto">
            <img
              src="<?=$st['img']?>"
              class="img img-responsive"
              alt="shop" />
          </div>
          <?php if($st['earn_zappta'] && $st['per_dollar']){ ?>
            <div class="text-center">
              <span class="text-success">+<?=$st['earn_zappta']?> / $<?=$st['per_dollar']?></span>
            </div>
          <?php } ?>
        </a>
      <?php } ?>
  </div>
  <?= $pager->links('default', 'zappta_new') ?>
</section>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>