<?php
/** @var $homeLink LinkItem */
/** @var $links array */

use frontend\widgets\breadcrumbs\LinkItem;

?>
<section class="section personal_main__inner">
    <div class="container">
        <div class="breadcrumbs">
            <ul>
                <li> <a href="<?= $homeLink->url ?>" title="<?= $homeLink->label ?>"> <i class="i i-home"></i><?= $homeLink->label ?></a></li>
                <?php if (!empty($links)): ?>
                    <?php foreach ($links as $link): ?>
                        <li> <?= $link ?></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</section>