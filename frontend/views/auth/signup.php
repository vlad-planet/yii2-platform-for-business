<?php

use frontend\models\auth\SignupForm;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $model SignupForm */
/* @var $this View */
/* @var $form ActiveForm */

$this->registerJsFile('/static/js/jquery.js', [
    'position' => $this::POS_HEAD
]);

?>

<div class="card">
    <div class="card-body login-card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group position-relative">
            <?= $form->field($model, SignupForm::ATTR_FIRST_NAME)
                ->textInput(['class' => 'form-control', 'placeholder' => 'Введите имя'])
                ->label(false) ?>
            <div class="input-group-append"></div>
        </div>

        <div class="form-group position-relative">
            <?= $form->field($model, SignupForm::ATTR_LAST_NAME)
                ->textInput(['class' => 'form-control', 'placeholder' => 'Введите фамилию'])
                ->label(false) ?>
            <div class="input-group-append"></div>
        </div>

        <div class="form-group position-relative">
            <?= $form->field($model, SignupForm::ATTR_SECOND_NAME)
                ->textInput(['class' => 'form-control', 'placeholder' => 'Введите отчество'])
                ->label(false) ?>
            <div class="input-group-append"></div>
        </div>

        <div class="form-group position-relative">
            <?= $form->field($model, SignupForm::ATTR_LOGIN)
                ->textInput(['class' => 'form-control', 'placeholder' => 'Введите email'])
                ->label(false) ?>
            <div class="input-group-append"></div>
        </div>

        <div class="form-group position-relative">
            <?= $form->field($model, SignupForm::ATTR_PHONE)
                ->widget(
                    MaskedInput::class,
                    [
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Введите номер телефона'
                        ],
                        'mask' => '+7 999 999 99 99'
                    ]
                )
                ->label(false) ?>
            <div class="input-group-append"></div>
        </div>

        <div class="form-group position-relative">
            <?= $form->field($model, SignupForm::ATTR_PASSWORD_FIRST)
                ->passwordInput(['class' => 'form-control', 'placeholder' => 'Введите пароль'])
                ->label(false) ?>
        </div>

        <div class="form-group position-relative">
            <?= $form->field($model, SignupForm::ATTR_PASSWORD_SECOND)
                ->passwordInput(['class' => 'form-control', 'placeholder' => 'Повторите пароль'])
                ->label(false) ?>
        </div>

        <div class="row">
            <div class="col-5 offset-4">
                <button type="submit" class="btn btn-primary btn-block">Регистрация</button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>