<?php

use backend\controllers\UserController;

use backend\controllers\UserVerificationController;
use common\models\db\Users;

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \backend\models\user\UserSearch */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content-header">
    <h1><?= $this->title; ?></h1>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-2 mb-2">
                            <?= Html::a(
                                'Добавить',
                                Url::to(UserController::getUrlRoute(UserController::ACTION_CREATE)),
                                ['class' => 'btn btn-success']
                            ); ?>
                            <br>
                        </div>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel'   => $searchModel,
                        'layout'        =>"{summary}\n{items}",
                        'columns' => [
                            Users::ATTR_LOGIN,
                            Users::ATTR_FIRST_NAME,
                            Users::ATTR_SECOND_NAME,
                            Users::ATTR_LAST_NAME,
                            [
                                'attribute' => Users::ATTR_STATUS,
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return $data->getStatusVariantsLabel();
                                },
                                'headerOptions' => ['style' => 'width:10%'],
                                'filter' => Users::getStatusVariants()
                            ],
                            [
                                'attribute' => Users::ATTR_DATE_CREATE,
                                'headerOptions' => ['style' => 'width:15%'],
                                'value' => function ($data) {
                                    return Yii::$app->formatter->asDate($data->date_create);
                                },
                                'filter'    => DatePicker::widget([
                                    'model'         => $searchModel,
                                    'attribute'     => Users::ATTR_DATE_CREATE,
                                    'options'       => ['placeholder' => 'Выберете дату'],
                                    'pluginOptions' => [
                                        'format'    => 'yyyy-mm-dd',
                                    ]
                                ]),
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Действия',
                                'headerOptions' => ['style' => 'width:14%'],
                                'template' => '{view} {update} {delete} {verify}',
                                'buttons' => [
                                    'verify' => function ($url, $model, $key) {
                                        if ($model->status === Users::STATUS_NEW) {
                                            //Текст в title ссылки, что виден при наведении
                                            $title = \Yii::t('yii', 'Верификация');

                                            return Html::a(
                                                'Верификация',
                                                Url::to(UserVerificationController::getUrlRoute(UserVerificationController::ACTION_CREATE, ['id' => $model->id])),
                                                [
                                                    'class' => 'btn btn-info',
                                                    'title' => $title,
                                                    'aria-label' => $title,
                                                    'data-pjax' => '0',
                                                    'id' => 'verify-' . $key
                                                ]
                                            );
                                        }
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a(
                                            '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                    <path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"></path>
                                                </svg>',
                                            ['delete', 'id' => $model->id],
                                            [
                                                'data' => [
                                                    'confirm' => 'ВНИМАНИЕ! При удалении пользователя, будет удалено всё, что связано с ним!!!',
                                                    'method' => 'post',
                                                ],
                                            ]);
                                    }
                                ]
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <nav aria-label="Page navigation">
                <?= LinkPager::widget([
                    'pagination'                    => $dataProvider->pagination,
                    'maxButtonCount'                => 10,
                    'linkOptions'                   => [
                        'class' => 'page-link'
                    ],
                    'pageCssClass'                  => [
                        'class' => 'page-item'
                    ],
                    'disabledListItemSubTagOptions' => [
                        'tag'   => 'a',
                        'class' => 'page-link'
                    ],
                    'nextPageLabel'                 => 'Вперед',
                    'prevPageLabel'                 => 'Назад',
                    'firstPageLabel'                => 'В начало',
                    'lastPageLabel'                 => 'В конец',
                    'nextPageCssClass'              => 'page-item',
                    'prevPageCssClass'              => 'page-item',
                    'firstPageCssClass'             => 'page-item',
                    'lastPageCssClass'              => 'page-item'
                ]); ?>
            </nav>
        </div>
    </div>
</div>