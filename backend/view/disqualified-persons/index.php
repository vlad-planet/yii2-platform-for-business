<?php

use backend\controllers\DisqualifiedPersonsController;
use backend\models\disqualified_persons\ImportForm;

use common\models\db\DisqualifiedPersons;

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\disqualified_persons\DisqualifiedPersonsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Реестр дисквалифицированных лиц';
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
                        <div class=" col-md-1">
                            <?= Html::a(
                                'Добавить',
                                Url::to(DisqualifiedPersonsController::getUrlRoute(DisqualifiedPersonsController::ACTION_CREATE)),
                                ['class' => 'btn btn-success']
                            ); ?>
                            <br>
                        </div>
                        <div class="col-md-2">
                            <?= Html::beginForm(Url::to(DisqualifiedPersonsController::getUrlRoute(DisqualifiedPersonsController::ACTION_IMPORT)), 'POST', [
                                'class' => 'js-import-form',
                                'enctype' => 'multipart/form-data'
                            ]); ?>
                            <?= Html::fileInput(ImportForm::ATTR_FILE_TO_IMPORT, null, [
                                'style' => 'display: none',
                                'class' => 'js-import-file-field',
                                'id' => 'import-xls'
                            ]); ?>
                            <label class="js-import-form_button" for="import-xls">
                                <span class="btn btn-block btn-primary" type="">Загрузка excel</span>
                            </label>
                            <input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
                            <?= Html::endForm(); ?>
                        </div>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'layout' => "{summary}\n{items}",
                            'options' => [
                                'class' => 'table-responsive',
                            ],
                            'summary' => "Показано <b>{begin}-{end}</b> из <b>{totalCount}</b> записей",
                            'columns' => [
                                DisqualifiedPersons::ATTR_NUMBER_IN_REESTR,
                                DisqualifiedPersons::ATTR_FIO,
                                [
                                    'attribute' => DisqualifiedPersons::ATTR_B_DAY,
                                    'headerOptions' => ['style' => 'width:15%'],
                                    'value' => function ($data) {
                                        return Yii::$app->formatter->asDate($data->b_day);
                                    },
                                    'filter' => DatePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => DisqualifiedPersons::ATTR_B_DAY,
                                        'options' => ['placeholder' => 'Выберете дату'],
                                        'pluginOptions' => [
                                            'format' => 'yyyy-mm-dd',
                                        ]
                                    ]),
                                ],
                                DisqualifiedPersons::ATTR_B_PLACE,
                                DisqualifiedPersons::ATTR_COMPANY,
                                DisqualifiedPersons::ATTR_INN,
                                DisqualifiedPersons::ATTR_POSITION,
                                DisqualifiedPersons::ATTR_ARTICLE_CODE,
                                DisqualifiedPersons::ATTR_BODY_TITLE,
                                DisqualifiedPersons::ATTR_JUDGE_FIO,
                                DisqualifiedPersons::ATTR_JUDGE_POSITION,
                                [
                                    'attribute' => DisqualifiedPersons::ATTR_DATE_START,
                                    'headerOptions' => ['style' => 'width:15%'],
                                    'value' => function ($data) {
                                        return Yii::$app->formatter->asDate($data->date_start);
                                    },
                                    'filter' => DatePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => DisqualifiedPersons::ATTR_DATE_START,
                                        'options' => ['placeholder' => 'Выберете дату'],
                                        'pluginOptions' => [
                                            'format' => 'yyyy-mm-dd',
                                        ]
                                    ]),
                                ],
                                [
                                    'attribute' => DisqualifiedPersons::ATTR_DATE_END,
                                    'headerOptions' => ['style' => 'width:15%'],
                                    'value' => function ($data) {
                                        return Yii::$app->formatter->asDate($data->date_end);
                                    },
                                    'filter' => DatePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => DisqualifiedPersons::ATTR_DATE_END,
                                        'options' => ['placeholder' => 'Выберете дату'],
                                        'pluginOptions' => [
                                            'format' => 'yyyy-mm-dd',
                                        ]
                                    ]),
                                ],
                                [
                                    'attribute' => DisqualifiedPersons::ATTR_DATE_CREATE,
                                    'headerOptions' => ['style' => 'width:15%'],
                                    'value' => function ($data) {
                                        return Yii::$app->formatter->asDate($data->date_create);
                                    },
                                    'filter' => DatePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => DisqualifiedPersons::ATTR_DATE_CREATE,
                                        'options' => ['placeholder' => 'Выберете дату'],
                                        'pluginOptions' => [
                                            'format' => 'yyyy-mm-dd',
                                        ]
                                    ]),
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Действия',
                                    'template' => '{update}&nbsp;&nbsp;{delete}',
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
                        'pagination' => $dataProvider->pagination,
                        'maxButtonCount' => 10,
                        'linkOptions' => [
                            'class' => 'page-link'
                        ],
                        'pageCssClass' => [
                            'class' => 'page-item'
                        ],
                        'disabledListItemSubTagOptions' => [
                            'tag' => 'a',
                            'class' => 'page-link'
                        ],
                        'nextPageLabel' => 'Вперед',
                        'prevPageLabel' => 'Назад',
                        'firstPageLabel' => 'В начало',
                        'lastPageLabel' => 'В конец',
                        'nextPageCssClass' => 'page-item',
                        'prevPageCssClass' => 'page-item',
                        'firstPageCssClass' => 'page-item',
                        'lastPageCssClass' => 'page-item'
                    ]); ?>
                </nav>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    const PersonalImportJS = {
        selectors: {
            importFileField: '.js-import-file-field',
            importFileForm: '.js-import-form'
        },
        events: function () {
            $(document).on('change', PersonalImportJS.selectors.importFileField, function () {
                $(PersonalImportJS.selectors.importFileForm).submit();
            });
        },
        init: function () {
            this.events();
        }
    };

    $(function () {
        PersonalImportJS.init();
    });

</script>