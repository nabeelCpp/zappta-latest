<?php
$assets_url = App\Helpers\ZapptaHelper::loadAssetsUrl(); ?>
<div class="pagination">
    <a <?=$pager->hasPreviousPage() ? 'href="'.$pager->getPreviousPage().'"' : 'type="button" disabled' ?> class="previous"><img src="<?= $assets_url ?>/images/chevron-left.svg" alt="" /> Previous</a>
    <a <?=$pager->hasNextPage() ? 'href="'.$pager->getNextPage().'"' : 'type="button" disabled' ?> class="next">Next <img src="<?= $assets_url ?>/images/chevron-right.svg" alt="" /> </a>
    <?php $current_page = isset($_GET['page']) ? $_GET['page'] : 1;?>
    <select class="select-control" onchange="location.href=this.value">
        <?php foreach ($pager->links() as $link){ ?>
        <option value="<?=$link['uri']?>" <?=$current_page == $link['title'] ? 'selected': ''?>>
            <?=$link['title']?>
        <?php } ?>
    </select>
</div>