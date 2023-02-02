<?php

use backend\controllers\UserController;
use backend\controllers\UserVerificationController;
use backend\models\user_verification\UserVerificationItem;

use common\models\db\Users;
use common\models\service\FileService;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\db\Users */
/* @var $userVerification UserVerificationItem */
/* @var $docs backend\models\user_documents\UserDocumentItem[] */

$this->title = $model->getFullShortName();
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => [UserController::ACTION_INDEX]];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=d592eda8-f208-444c-9fec-b191de419547', [
    'position' => $this::POS_HEAD
]);
$this->registerJsFile('/static/js/YaMap.js', [
    'position' => $this::POS_HEAD
]);

$this->registerCssFile('/css/personal.css');
?>

<div class="card">
    <div class="card-body">
        <div class="scuds-view">

            <?= $this->render('_btn-group', [
                'model' => $model,
            ]) ?>

            <h1><?= Html::encode($this->title) ?></h1>
            <p>
                <?= Html::a('Изменить', [UserController::ACTION_UPDATE, 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

                <?php if ($model->status === Users::STATUS_NEW): ?>
                    <?= Html::a(
                        'Верификация',
                        Url::to(UserVerificationController::getUrlRoute(UserVerificationController::ACTION_CREATE, ['id' => $model->id])),
                        ['class' => 'btn btn-info']
                    ) ?>
                <?php endif; ?>

                <?php if ($model->status !== Users::STATUS_DEACTIVATE): ?>
                    <?= Html::a(
                        'Деактивация',
                        Url::to(UserController::getUrlRoute(UserController::ACTION_DELETE, ['id' => $model->id])),
                        ['class' => 'btn btn-danger', 'data-method' => 'POST']
                    ) ?>
                <?php endif; ?>

            </p>
            <div class="card">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        Users::ATTR_LOGIN,
                        Users::ATTR_FIRST_NAME,
                        Users::ATTR_SECOND_NAME,
                        Users::ATTR_LAST_NAME,
                        Users::ATTR_PHONE_NUMBER,
                        [
                            'attribute' => Users::ATTR_STATUS,
                            'format' => 'raw',
                            'value' => function ($data) {
                                return $data->getStatusVariantsLabel();
                            },
                            'headerOptions' => ['style' => 'width:10%'],
                        ],
                        [
                            'attribute' => Users::ATTR_DATE_CREATE,
                            'headerOptions' => ['style' => 'width:13%'],
                            'value' => function ($data) {
                                return Yii::$app->formatter->asDate($data->date_create);
                            }
                        ],
                    ],
                    'template' => "<tr><th style='width: 15%;'>{label}</th><td>{value}</td></tr>"
                ]) ?>
            </div>
            <?php if ($model->status === Users::STATUS_CONFIRMED): ?>
                <div class="card p-2">
                    <h3>Данные верификации</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label"">Геолокация верификации</label>
                            <div id="map"></div>
                            <input type="hidden" class="j-geoposition" value="<?= $userVerification->geo_data ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label"">Дата верификации</label>
                            <?= $userVerification->date_create ?>
                        </div>
                    </div>
                    <?php if (!empty($userVerification->photos)): ?>
                        <?php foreach ($userVerification->photos as $photo): ?>
                            <img src="<?= FileService::getPath($photo) ?>">
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?= $this->render('_docs', ['docs' => $docs]); ?>
        </div>
    </div>
</div>

<script>
    $(() => {
        YaMap.mapClick = false;
        ymaps.ready(YaMap.init);
    })
</script>
<style>
    #map {
        width: 600px;
        height: 400px;
        padding-bottom: 10px;
    }
</style>