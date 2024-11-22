<?php foreach ($notifications as $key => $n) { ?>
    <li <?= !$n['is_read'] ? 'class="bg-grey"' : '' ?>>
        <div class="d-flex gap-2 notifiNotesWrap">
            <span><img src="<?= $assets_url ?>/images/notification-bing.svg" alt="" /></span>
            <div class="notifiNotes">
                <h5><a href="<?= $n['link'] ?>"><?=str_replace('-', ' ', ucfirst($n['category']))?></a> <?= !$n['is_read'] ? '<span class="newNotify">New</span>' : '' ?></h5>
                <p><?=$n['notification']?></p>
                <p><?=timeago($n['created_at'])?></p>
            </div>
        </div>
    </li>
<?php } ?>