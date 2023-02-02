<?php

use backend\controllers\NewsCommentsController;
use common\models\db\NewsComments;

use yii\web\YiiAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\db\NewsComments */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Коментарии к новостям', 'url' => [NewsCommentsController::ACTION_INDEX]];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<div class="news-comments-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', [NewsCommentsController::ACTION_UPDATE, 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', [NewsCommentsController::ACTION_DELETE, 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="card">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            NewsComments::ATTR_ID,
            NewsComments::ATTR_NEWS_ID,
            NewsComments::ATTR_USER_ID,
            NewsComments::ATTR_PARENT_ID,
            [
                'attribute' => NewsComments::ATTR_DATE_CREATE,
                'headerOptions' => ['style' => 'width:13%'],
                'value' => function ($data) {
                    return Yii::$app->formatter->asDate($data->date_create);
                }
            ],
            NewsComments::ATTR_TEXT,
            [
                'attribute' => NewsComments::ATTR_ACTIVE,
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->getActiveStatusVariantsLabel();
                },
                'headerOptions' => ['style' => 'width:10%'],
                'filter' => NewsComments::getActiveStatusVariants()
            ],
        ],
    ]) ?>
</div>
</div>
