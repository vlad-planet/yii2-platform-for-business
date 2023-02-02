<?php

use frontend\models\notifications\NotificationsSearch;
use yii\web\View;

/** @var $result NotificationsSearch */
/** @var $this View */
?>

<section class="section search__result__inner">
    <div class="container">
        <?php
        if(!empty($result->items)){
            foreach ($result->items as $item):
                echo $item->text;
                echo $item->date_create;
            endforeach;
        }

        ?>
    </div>
</section>