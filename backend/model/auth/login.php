<?php

use frontend\models\auth\AuthForm;
use yii\widgets\ActiveForm;

/* @var $model AuthForm */
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
			<?= $form->field($model, AuthForm::ATTR_LOGIN)
				->textInput(['class' => 'form-control', 'placeholder' => 'Введите логин или номер телефона'])
				->label(false) ?>
			<div class="input-group-append"></div>
		</div>

		<div class="form-group position-relative">
			<?= $form->field($model, AuthForm::ATTR_PASSWORD)
				->input('password', ['class' => 'form-control', 'placeholder' => 'Введите пароль'])
				->label(false) ?>
		</div>

		<div class="row">
			<div class="col-8">
				<div class="icheck-primary">
					<?= $form->field($model, AuthForm::ATTR_REMEMBER_ME)
						->checkbox(['value' => true, 'checked ' => true]); ?>
				</div>
			</div>
			<div class="col-4">
				<button type="submit" class="btn btn-primary btn-block">ВОЙТИ</button>
			</div>
		</div>
		<?php ActiveForm::end(); ?>

		<?= yii\authclient\widgets\AuthChoice::widget([
			 'baseAuthUrl' => ['auth/social'],
			 'popupMode' => true,
		]) ?>
	</div>
</div>