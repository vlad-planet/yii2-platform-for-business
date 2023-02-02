<?php

use frontend\models\news\NewsSearchResult;
use frontend\widgets\breadcrumbs\BreadcrumbsWidget;
use frontend\widgets\pagination\Paginator;

/** @var $result NewsSearchResult */

$this->registerJsFile(Yii::$app->params['staticPath'] . '/js/NewsComments.js', ['depends' => 'frontend\assets\AppAsset']);

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= BreadcrumbsWidget::widget([
    'homeLink' => [
        'label' => 'Главная ',
        'url' => Yii::$app->homeUrl,
    ],
    'links' => $this->params['breadcrumbs'] ?? [],
])?>

<?php if (!empty($result->items)): ?>
<section class="section listnews_main__inner">
    <div class="container">
        <div class="title-header">Новости проекта</div>
        <div class="list__newsbox">

        <?php foreach ($result->items as $item): ?>
            <?= $this->render('_item', ['item' => $item]); ?>
        <?php endforeach; ?>

        <div class="list__pagination">
            <?= Paginator::widget([
                'pagination' => $result->pagination,
            ]); ?>
        </div>

        </div>
    </div>
</section>
<?php endif; ?>