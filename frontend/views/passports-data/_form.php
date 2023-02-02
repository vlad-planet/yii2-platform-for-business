<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\db\PassportsData;

/* @var $this yii\web\View */
/* @var $model common\models\db\PassportsData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="passports-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, PassportsData::ATTR_BDAY)->textInput() ?>

    <?= $form->field($model, PassportsData::ATTR_SERIAL)->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, PassportsData::ATTR_NUMBER)->textInput() ?>

    <?= $form->field($model, PassportsData::ATTR_ISSUE_DATE)->textInput() ?>

    <?= $form->field($model, PassportsData::ATTR_ISSUE_ID)->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, PassportsData::ATTR_PLACE_BDAY)->textarea(['rows' => 6]) ?>

    <?= $form->field($model, PassportsData::ATTR_PLACE_REGISTRATION)->textarea(['rows' => 6]) ?>

    <?= $form->field($model, PassportsData::ATTR_GENDER)->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
