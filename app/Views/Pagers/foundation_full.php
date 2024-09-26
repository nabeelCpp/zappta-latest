<?php $pager->setSurroundCount(2) ?>
<nav aria-label="Page navigation">
    <ul class="pagination d-flex">
    <?php if ($pager->hasPreviousPage()) : ?>
        <li>
            <a href="<?php print $pager->getFirst() ?>">
                <span aria-hidden="true" class="fa-solid fa-angles-left"></span>
            </a>
        </li>
        <li>
            <a href="<?php print $pager->getPreviousPage() ?>" >
                <span aria-hidden="true" class="fa-solid fa-chevron-left"></span>
            </a>
        </li>
    <?php endif ?>
    <?php $current_page = isset($_GET['page']) ? $_GET['page'] : 1;?>
    <?php foreach ($pager->links() as $link): ?>
        <?php 
            if ( $current_page == $link['title'] ) {
                $active_pag = "active";
            } else{
                $active_pag = "";
            }
        ?>
        <li <?php print $link['active'] ? 'class="active"' : ''?>>
            <a href="<?php print $link['uri'] ?>">
                <?php print $link['title'] ?>
            </a>
        </li>
    <?php endforeach ?>

    <?php if ($pager->hasNextPage()) : ?>
        <li>
            <a href="<?php print $pager->getNextPage() ?>">
                <span aria-hidden="true"class="fa-solid fa-chevron-right"></span>
            </a>
        </li>
        <li>
            <a href="<?php print $pager->getLast() ?>">
                <span aria-hidden="true" class="fa-solid fa-angles-right"></span>
            </a>
        </li>
    <?php endif ?>
    </ul>
</nav>