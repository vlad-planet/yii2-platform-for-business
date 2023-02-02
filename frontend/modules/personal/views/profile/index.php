<?php

use frontend\modules\personal\controllers\IndexController;
use frontend\modules\personal\helpers\MenuLinksHelper;
use frontend\modules\personal\models\personal\PersonalProfileForm;
use frontend\widgets\breadcrumbs\BreadcrumbsWidget;
use frontend\widgets\profileMenu\ProfileMenuWidget;

use yii\bootstrap4\Modal;
use yii\helpers\Url;

/** @var $model PersonalProfileForm */

$this->registerJsFile('/static/js/uploadFile.js', ['depends' => 'frontend\assets\AppAsset']);
$this->registerJsFile('/static/js/Personal.js', ['depends' => 'frontend\assets\AppAsset']);

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = [
    'label' => 'Личный кабинет',
    'url' => Url::to(IndexController::getUrlRoute(IndexController::ACTION_INDEX))
];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
if (!empty($message)) {
    Modal::begin([
        'clientOptions' => ['show' => true],
        'headerOptions' => [
            'style' => 'display:none;'
        ],
        'footerOptions' => [
            'style' => 'display:none;'
        ],
    ]);
    echo $message;
    Modal::end();
} ?>

<?= BreadcrumbsWidget::widget([
    'homeLink' => [
        'label' => 'Главная',
        'url' => Yii::$app->homeUrl,
    ],
    'links' => $this->params['breadcrumbs'] ?? [],
]) ?>

<section class="section personal_main_content__inner">
    <div class="container tab-container">

        <!--Виджет меню профиля-->
        <?= ProfileMenuWidget::widget(['items' => MenuLinksHelper::getLinks()]) ?>

        <div class="tab-content">
            <div class="tab-content-item tab1">
                <div class="tab-section tab-addproduct-section">
                    <div class="addproduct-container">

                        <div class="title-header">Дополнительные данные персоны</div>
                        <?= $this->render('_form', ['model' => $model]); ?>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>