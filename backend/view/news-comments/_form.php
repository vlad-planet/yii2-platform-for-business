<?php

use common\models\service\UserService;

use backend\models\news\NewsService;
use backend\models\news_comments\NewsCommentsForm;
use backend\models\news_comments\NewsCommentsService;

use backend\controllers\NewsCommentsController;

use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\db\NewsComments */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, NewsCommentsForm::ATTR_NEWS_ID)->widget(Select2::Class, [
                'data' =>  NewsService::getListForSelect(),
                'options' => ['placeholder' => '---Выбрать---'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);	?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, NewsCommentsForm::ATTR_USER_ID)->widget(Select2::Class, [
                'data' =>  UserService::getListForSelect(),
                'options' => ['placeholder' => '---Выбрать---'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);	?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, NewsCommentsForm::ATTR_PARENT_ID)->widget(Select2::Class, [
                'data' =>  NewsCommentsService::getListForSelect(),
                'options' => ['placeholder' => '---Выбрать---'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);	?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, NewsCommentsForm::ATTR_TEXT)->widget(CKEditor::class); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, NewsCommentsForm::ATTR_ACTIVE)->checkbox(); ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::a(
            'Отмена',
            Url::to(NewsCommentsController::getUrlRoute(NewsCommentsController::ACTION_INDEX)),
            ['class' => 'btn btn-danger']
        ); ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
