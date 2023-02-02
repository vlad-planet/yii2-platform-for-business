<?php

use backend\controllers\UserController;

use common\models\db\MoneyBalanceLogs;

use kartik\date\DatePicker;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\db\Users */
/* @var $searchModel MoneyBalanceLogs */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = $model->getFullShortName();
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => [UserController::ACTION_INDEX]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="card">
    <div class="card-body">

        <?= $this->render('_btn-group', [
            'model' => $model,
        ]) ?>

        <div class="row justify-content-md-center">
            <div class="col-md-auto">
                <div class="info-box mb-3 bg-warning">
                    <span class="info-box-icon"><i class="fas fa-ruble-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Баланс пользователя <?= $this->title ?></span>
                        <span class="info-box-number"><?= $model->balance->value ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel'   => $searchModel,
                    'layout'        =>"{summary}\n{items}",
                    'summary'       =>"Показано <b>{begin}-{end}</b> из <b>{totalCount}</b> записей",
                    'columns' => [
                        [
                            'attribute' => MoneyBalanceLogs::ATTR_DATE_CREATE,
                            'headerOptions' => ['style' => 'width:30%'],
                            'value' => function ($data) {
                                return Yii::$app->formatter->asDate($data->date_create);
                            },
                            'filter'    => DatePicker::widget([
                                'language'      => 'ru',
                                'model'         => $searchModel,
                                'attribute'     => MoneyBalanceLogs::ATTR_DATE_CREATE,
                                'options'       => ['placeholder' => 'Выберете дату'],
                                'pluginOptions' => [
                                    'format'    => 'yyyy-mm-dd',
                                    'autoclose' => true,
                                ]
                            ]),
                        ],
                        MoneyBalanceLogs::ATTR_VALUE,
                        MoneyBalanceLogs::ATTR_CHANGE,
                        MoneyBalanceLogs::ATTR_COMMENT,
                    ],
                ]) ?>
            </div>
        </div>

    </div>
</div>
