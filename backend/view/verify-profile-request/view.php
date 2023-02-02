<?php

use backend\controllers\VerifyProfileRequestController;

use common\models\db\VerifyProfileRequest;
use common\models\service\FileService;

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model VerifyProfileRequest  */

$this->title = 'Детальный просмотр';
$this->params['breadcrumbs'][] = [
    'label' => 'Запрос на внесение персональных данных',
    'url'   => [VerifyProfileRequestController::ACTION_INDEX]
];
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
                        <div class=" col-md-12 mb-12">
                            <h3>Запрос</h3>
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    VerifyProfileRequest::ATTR_ID,
                                    [
                                        'attribute' =>  VerifyProfileRequest::ATTR_DATE_CREATE,
                                        'value' => $model->date_create,
                                    ],
                                    [
                                        'attribute' =>  VerifyProfileRequest::ATTR_USER_ID,
                                        'value' => function ($model) {return $model->users->getFullName(); },
                                        'format' => 'raw'
                                    ],
                                    [
                                        'attribute' =>  VerifyProfileRequest::ATTR_STATUS,
                                        'value' => function ($model) { return VerifyProfileRequest::getStatusVariants()[$model->status]; },
                                        'format' => 'raw'
                                    ]
                                ]
                            ]) ?>

                            <h3>Пасспортные данные</h3>
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    VerifyProfileRequest::ATTR_PASSPORT_NATIONALITY,
                                    VerifyProfileRequest::ATTR_PASSPORT_NUMBER,
                                    [
                                        'attribute' =>  VerifyProfileRequest::ATTR_PASSPORT_DATE_ISSUE,
                                        'value' => $model->passport_date_issue,
                                    ],
                                    VerifyProfileRequest::ATTR_PASSPORT_OFFICE,
                                    VerifyProfileRequest::ATTR_PASSPORT_WHOM_ISSUED,
                                    VerifyProfileRequest::ATTR_PASSPORT_BIRTH_PLACE,
                                    [
                                        'attribute' =>  VerifyProfileRequest::ATTR_PASSPORT_BDAY_PLACE,
                                        'value' => $model->passport_bday_place,
                                    ],
                                    [
                                        'attribute' =>  VerifyProfileRequest::ATTR_PASSPORT_FILE,
                                        'value' => function ($model) {
                                            if (!empty($model->passport_file)) {
                                                return Html::a('Скачать файл', FileService::getById($model->passport_file), ['class' => '', 'target' => '_blank']);
                                            }   return '';
                                        },
                                        'format' => 'raw',
                                    ],
                                    VerifyProfileRequest::ATTR_PASSPORT_RESIDENT_ADDRESS,
                                    VerifyProfileRequest::ATTR_PASSPORT_FACT_RESIDENT_ADDRESS,
                                ]
                            ]) ?>

                            <h3>Персональные данные</h3>
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    VerifyProfileRequest::ATTR_PERSONAL_DATA_INN,
                                    VerifyProfileRequest::ATTR_PERSONAL_DATA_SNILS,
                                    VerifyProfileRequest::ATTR_PERSONAL_DATA_DRIVING_LICENSE,
                                    [
                                        'attribute' =>  VerifyProfileRequest::ATTR_PERSONAL_DATA_ADDITIONAL_FILES,
                                        'value' => function ($model) {
                                            if (!empty($model->personal_data_additional_files)) {
                                                return Html::a('Скачать файл', FileService::getById($model->personal_data_additional_files), ['class' => '', 'target' => '_blank']);
                                            }   return '';
                                        },
                                        'format' => 'raw'
                                    ]
                                ]
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>