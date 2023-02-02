<?php

use frontend\widgets\profileMenu\models\MenuItem;

/** @var MenuItem[] $items */
?>

<ul class="tab-links">

    <?php $i = 1; ?>
    <?php foreach ($items as $item): ?>

        <li class="<?= $item->active ? 'active' : '' ?>">
            <a class="js--tab-<?= $i ?>" href="<?= $item->url ?>" title="<?= $item->label ?>" rel="follow">
                <?= $item->label ?>
            </a>
        </li>

    <?php $i++; ?>
    <?php endforeach; ?>

</ul>