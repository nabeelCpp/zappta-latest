<div class="container-fluid p-5 px-5" id="ajaxWinners">
    <div class="lunarSection">
        <?php foreach ($compaigns as $key => $comp) { ?>
            <div class="saleheading">
                <h1><?= $comp['campaign_name'] ?></h1>
                <p><span>Ended date:</span> <?= date('d-M-Y', strtotime($comp['campaign_end_date'])) ?></p>
            </div>
            <?php if(isset($comp['sprees']) && count($comp['sprees'])) { ?>
                <div class="lunarSalePost">
                    <div class="row">
                        <?php foreach ($comp['sprees'] as $key => $spree) { ?>
                            <div class="col-sm-6">
                                <div class="lunarInner">
                                    <div class="lunartop">
                                        <h3>Winner</h3>
                                        <div class="btnSale">
                                            <p>Reward</p>
                                            <button class="btn btn-danger zappta-red-bg btn-lg px-4 mb-3">
                                                $<?= $spree['spree_reward'] ?>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="lunarLogo">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="lunarName">
                                                    <?php if($spree['top_scorer_name']) { ?> 
                                                        <p>Name: <span><?= $spree['top_scorer_name'] ?></span></p>
                                                        <p>Score:</p>
                                                        <h4><?= $spree['top_scorer_score'] ?></h4>
                                                    <?php } else {
                                                        echo '<small class="text-muted">No player played!</small>'; 
                                                    }?>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="logoLunar">
                                                    <img src="<?= $spree['spree_logo'] ?>" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>