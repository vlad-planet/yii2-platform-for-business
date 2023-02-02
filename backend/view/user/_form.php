<?php

use backend\models\user\UserForm;
use backend\controllers\UserController;

use common\models\db\Users;

use common\models\service\UserService;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\db\Users */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['enableClientScript' => false]); ?>
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, UserForm::ATTR_FIRST_NAME)
				->textInput(['class' => 'form-control', 'placeholder' => 'Введите имя'])
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, UserForm::ATTR_LAST_NAME)
				->textInput(['class' => 'form-control', 'placeholder' => 'Введите фамилию'])
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, UserForm::ATTR_SECOND_NAME)
				->textInput(['class' => 'form-control', 'placeholder' => 'Введите отчество'])
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, UserForm::ATTR_LOGIN)
				->textInput(['class' => 'form-control', 'placeholder' => 'Введите email'])
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, UserForm::ATTR_PHONE_NUMBER)
				->widget(
					MaskedInput::class,
					[
						'options' => [
							'class' => 'form-control',
							'placeholder' => 'Введите номер телефона'
						],
						'mask' => '+7 (999) 999 99 99'
					]
				)
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, UserForm::ATTR_PASSWORD_FIRST)
				->passwordInput(['class' => 'form-control', 'placeholder' => 'Введите пароль'])
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, UserForm::ATTR_PASSWORD_SECOND)
				->passwordInput(['class' => 'form-control', 'placeholder' => 'Повторите пароль'])
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
            <label class="control-label" for="userform-status">Статус</label>
			<p><?= (Users::getStatusVariants())[$model->status ?? 1] ?></p>
		</div>
	</div>

	<div class="row form-group">
		<div class="col-md-12">
			<?= Html::a(
				'Отмена',
				Url::to(UserController::getUrlRoute(UserController::ACTION_INDEX)),
				['class' => 'btn btn-danger']
			); ?>
			<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
		</div>
	</div>
<?php ActiveForm::end(); ?>