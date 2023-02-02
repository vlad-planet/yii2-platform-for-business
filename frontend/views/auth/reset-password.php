<?php

use frontend\models\auth\ResetPasswordForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model ResetPasswordForm */

$this->title = 'Сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <div class="card-body login-card-body ">
        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']);?>
        <div class="form-group position-relative">
            <?= $form->field($model, ResetPasswordForm::ATTR_PASSWORD)->passwordInput(['autofocus' => true]) ?>
            <div class="input-group-append"></div>
        </div>
        <div class="form-group position-relative">
            <?= $form->field($model, ResetPasswordForm::ATTR_PASSWORD_CONFIRM)->passwordInput() ?>
            <div class="input-group-append"></div>
        </div>

        <div class="row">
            <div class="offset-2 col-5">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>