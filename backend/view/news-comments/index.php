<?php

use backend\controllers\NewsCommentsController;
use backend\models\news\NewsService;

use common\models\db\News;
use common\models\db\NewsComments;
use common\models\service\UserService;

use kartik\select2\Select2;
use kartik\date\DatePicker;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\news_comments\NewsCommentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комментарии к новостям';
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
                                Url::to(NewsCommentsController::getUrlRoute(NewsCommentsController::ACTION_CREATE)),
                                ['class' => 'btn btn-success']
                            ); ?>
                            <br>
                        </div>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel'  => $searchModel,
                        'layout'       => "{summary}\n{items}",
                        'columns'      => [
                            [
                                'attribute'     => NewsComments::ATTR_NEWS_ID,
                                'format'        => 'raw',
                                'headerOptions' => ['style' => 'width:10%'],
                                'value'         => function (NewsComments $data) {
                                    return Html::a($data->news->title, 'https://'.$_SERVER['SERVER_NAME'].'/news/'.$data->news->alias, ['target'=>'_blank']);
                                },
                                'filter'  => Select2::widget([
                                    'name'    => NewsComments::ATTR_NEWS_ID,
                                    'data'    => NewsService::getListForSelect(),
                                    'options' => ['placeholder' => '---Выбрать---']
                                ]),
                            ],
                            [
                                'attribute'     => NewsComments::ATTR_USER_ID,
                                'format'        => 'raw',
                                'headerOptions' => ['style' => 'width:10%'],
                                'value'         => function (NewsComments $data) {
                                    return $data->users->login;
                                },
                                'filter'  => Select2::widget([
                                    'name'    => NewsComments::ATTR_USER_ID,
                                    'data'    => UserService::getListForSelect(),
                                    'options' => ['placeholder' => '---Выбрать---']
                                ]),
                            ],
                            [
                                'attribute' => NewsComments::ATTR_DATE_CREATE,
                                'headerOptions' => ['style' => 'width:15%'],
                                'value' => function ($data) {
                                    return Yii::$app->formatter->asDatetime($data->date_create);
                                },
                                'filter'    => DatePicker::widget([
                                    'model'         => $searchModel,
                                    'attribute'     => NewsComments::ATTR_DATE_CREATE,
                                    'options'       => ['placeholder' => 'Выберете дату'],
                                    'pluginOptions' => [
                                        'format'    => 'yyyy-mm-dd',
                                    ]
                                ]),
                            ],
                            [
                                'attribute' => NewsComments::ATTR_TEXT,
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::decode($data->text);
                                }
                            ],
                            [
                                'attribute'     => NewsComments::ATTR_ACTIVE,
                                'format'        => 'raw',
                                'value'         => function ($data) {
                                    return $data->getActiveStatusVariantsLabel();
                                },
                                'headerOptions' => ['style' => 'width:10%'],
                                'filter'        => NewsComments::getActiveStatusVariants()
                            ],
                            [
                                'class'         => 'yii\grid\ActionColumn',
                                'header'        => 'Действия',
                                'headerOptions' => ['style' => 'width:10%'],
                                'template'      => '{view} {update} {delete}'
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
