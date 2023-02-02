<?php

use backend\models\dynamic_pages\DynamicPagesForm;
use backend\controllers\DynamicPagesController;

use mihaildev\ckeditor\CKEditor;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\db\DynamicPages */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, DynamicPagesForm::ATTR_TITLE)->textInput(['maxlength' => 255]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, DynamicPagesForm::ATTR_ALIAS)->textInput(['maxlength' => 255]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, DynamicPagesForm::ATTR_TEXT)->widget(CKEditor::class); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<?= $form->field($model, DynamicPagesForm::ATTR_ACTIVE)->checkbox(); ?>
		</div>
	</div>
	<div class="form-group">
		<?= Html::a(
			'Отмена',
			Url::to(DynamicPagesController::getUrlRoute(DynamicPagesController::ACTION_INDEX)),
			['class' => 'btn btn-danger']
		); ?>
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
	</div>
<?php ActiveForm::end(); ?>