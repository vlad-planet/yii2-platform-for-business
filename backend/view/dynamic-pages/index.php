<?php

use backend\controllers\DynamicPagesController;

use common\models\db\DynamicPages;

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \backend\models\dynamic_pages\DynamicPagesSearch */

$this->title = 'Динамические страницы';
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
                        <div class=" col-md-2 mb-2">
                            <?= Html::a(
                                'Добавить',
                                Url::to(DynamicPagesController::getUrlRoute(DynamicPagesController::ACTION_CREATE)),
                                ['class' => 'btn btn-success']
                            ); ?>
                            <br>
                        </div>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel'   => $searchModel,
                        'layout'        =>"{summary}\n{items}",
                        'summary'       =>"Показано <b>{begin}-{end}</b> из <b>{totalCount}</b> записей",
                        'columns' => [
                            DynamicPages::ATTR_TITLE,
                            DynamicPages::ATTR_ALIAS,
                            [
                                'attribute' => DynamicPages::ATTR_TEXT,
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::decode($data->text);
                                }
                            ],
                            [
                                'attribute' => DynamicPages::ATTR_ACTIVE,
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return $data->getActiveStatusVariantsLabel();
                                },
                                'headerOptions' => ['style' => 'width:10%'],
                                'filter' => DynamicPages::getActiveStatusVariants()
                            ],
                            [
                                'attribute' => DynamicPages::ATTR_DATE_CREATE,
                                'headerOptions' => ['style' => 'width:15%'],
                                'value' => function ($data) {
                                    return Yii::$app->formatter->asDate($data->date_create);
                                },
                                'filter'    => DatePicker::widget([
                                    'model'         => $searchModel,
                                    'attribute'     => DynamicPages::ATTR_DATE_CREATE,
                                    'options'       => ['placeholder' => 'Выберете дату'],
                                    'pluginOptions' => [
                                        'format'    => 'yyyy-mm-dd',
                                    ]
                                ]),
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Действия',
                                'template'=> '{update}&nbsp;&nbsp;{delete}',
                                'headerOptions' => ['style' => 'width:10%'],
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