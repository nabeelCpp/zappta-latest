<?php 
$notifications_count = count_notifications();
?>
<li class="nav-item dropdown notifiDropdown">
    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="notify"><img src="<?= $assets_url ?>/images/notification-bing.svg" alt="" />
            <em><?=$notifications_count?></em>
        </span>


    </a>
    <ul class="dropdown-menu" aria-labelledby="notificationDropdown" id="notifications-area">
        <li><span class="d-flex align-items-center gap-3"><img src="<?= $assets_url ?>/images/notification-bing.svg" alt="" /> Notification (<?=$notifications_count?>)</span></li>

        <p id="loading-notifications" class="text-center">Loading....</p>
    </ul>
</li>