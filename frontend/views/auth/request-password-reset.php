<?php

use frontend\controllers\AuthController;
use frontend\models\auth\PasswordResetRequestForm;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model PasswordResetRequestForm */
$this->title = 'Востоновление пароля по email';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <div class="card-body login-card-body ">
        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']);?>
        <div class="form-group position-relative">
            <?= $form->field($model, PasswordResetRequestForm::ATTR_LOGIN)->textInput(['autofocus' => true]) ?>
            <div class="input-group-append"></div>
        </div>

        <div class="row">
            <div class="col-5">
                <?= Html::a('Назад', AuthController::getUrlRoute(AuthController::ACTION_LOGIN), ['class' => 'btn btn-danger btn-block'])?>
            </div>
            <div class="offset-2 col-5">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>