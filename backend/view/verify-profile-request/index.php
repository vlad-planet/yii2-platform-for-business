<?php

use backend\models\verify_profile_request\VerifyProfileRequestSearch;

use common\models\db\VerifyProfileRequest;

use kartik\date\DatePicker;

use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\verify_profile_request\VerifyProfileRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Запрос на внесение персональных данных';
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
                        </div>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel'   => $searchModel,
                        'layout'       => "{summary}\n{items}",
                        'summary'       =>"Показано <b>{begin}-{end}</b> из <b>{totalCount}</b> записей",
                        'columns' => [
                            [
                                'header' => $searchModel->attributeLabels()[VerifyProfileRequestSearch::ATTR_FIO],
                                'attribute' => VerifyProfileRequestSearch::ATTR_FIO,
                                'format' => 'raw',
                                'value' => function (VerifyProfileRequest $data) {
                                    return $data->users->getFullShortName();
                                }
                            ],
                            [
                                'header' => $searchModel->attributeLabels()[VerifyProfileRequestSearch::ATTR_LOGIN],
                                'attribute' => VerifyProfileRequestSearch::ATTR_LOGIN,
                                'format' => 'raw',
                                'value' => function (VerifyProfileRequest $data) {
                                    return $data->users->login;
                                }
                            ],
                            [
                                'header' => $searchModel->attributeLabels()[VerifyProfileRequestSearch::ATTR_PHONE_NUMBER],
                                'attribute' => VerifyProfileRequestSearch::ATTR_PHONE_NUMBER,
                                'format' => 'raw',
                                'value' => function (VerifyProfileRequest $data) {
                                    return $data->users->phone_number;
                                }
                            ],
                            [
                                'attribute'     => VerifyProfileRequestSearch::ATTR_DATE_CREATE,
                                'headerOptions' => ['style' => 'width:15%'],
                                'value'         => function ($data) {
                                    return $data->date_create;
                                },
                                'filter'        => DatePicker::widget([
                                    'model'         => $searchModel,
                                    'attribute'     => VerifyProfileRequestSearch::ATTR_DATE_CREATE,
                                    'options'       => ['placeholder' => 'Выберете дату'],
                                    'language'      => 'ru',
                                ]),
                            ],
                            [
                                'attribute'     => VerifyProfileRequest::ATTR_STATUS,
                                'format'        => 'raw',
                                'value'         => function ($data) {
                                    return $data->getStatusVariantsLabel();
                                },
                                'headerOptions' => ['style' => 'width:12%'],
                                'filter'        => VerifyProfileRequest::getStatusVariants()
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Действия',
                                'template'=> '{view}',
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