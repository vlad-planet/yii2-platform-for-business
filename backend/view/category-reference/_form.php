<?php

use backend\controllers\CategoryReferenceController;
use backend\models\category_reference\CategoryReferenceForm;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\db\CategoryReference */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, CategoryReferenceForm::ATTR_NAME)->textInput(['maxlength' => 255]) ?>
    </div>
</div>
<div class="form-group">
    <?= Html::a(
        'Отмена',
        Url::to(CategoryReferenceController::getUrlRoute(CategoryReferenceController::ACTION_INDEX)),
        ['class' => 'btn btn-danger']
    ); ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>