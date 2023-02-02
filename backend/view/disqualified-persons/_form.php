<?php

use backend\controllers\DisqualifiedPersonsController;
use backend\models\disqualified_persons\DisqualifiedPersonsForm;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\db\DisqualifiedPersons */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, DisqualifiedPersonsForm::ATTR_NUMBER_IN_REESTR)->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, DisqualifiedPersonsForm::ATTR_FIO)->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, DisqualifiedPersonsForm::ATTR_B_DAY)->input('date'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, DisqualifiedPersonsForm::ATTR_B_PLACE)->input('date'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, DisqualifiedPersonsForm::ATTR_COMPANY)->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, DisqualifiedPersonsForm::ATTR_INN)->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, DisqualifiedPersonsForm::ATTR_POSITION)->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, DisqualifiedPersonsForm::ATTR_ARTICLE_CODE)->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, DisqualifiedPersonsForm::ATTR_BODY_TITLE)->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, DisqualifiedPersonsForm::ATTR_JUDGE_FIO)->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, DisqualifiedPersonsForm::ATTR_JUDGE_POSITION)->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, DisqualifiedPersonsForm::ATTR_DATE_START)->input('date'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <?= $form->field($model, DisqualifiedPersonsForm::ATTR_DATE_END)->input('date'); ?>
            </div>
        </div>

<div class="form-group">
    <?= Html::a(
        'Отмена',
        Url::to(DisqualifiedPersonsController::getUrlRoute(DisqualifiedPersonsController::ACTION_INDEX)),
        ['class' => 'btn btn-danger']
    ); ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>