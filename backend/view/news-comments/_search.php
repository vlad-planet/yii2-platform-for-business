<?php

use backend\controllers\NewsCommentsController;
use backend\models\news_comments\NewsCommentsSearch;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\news_comments\NewsCommentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                <?php $form = ActiveForm::begin([
                    'action' => [NewsCommentsController::ACTION_INDEX],
                    'method' => 'get',
                ]); ?>

                <?= $form->field($model, NewsCommentsSearch::ATTR_ID) ?>

                <?= $form->field($model, NewsCommentsSearch::ATTR_NEWS_ID) ?>

                <?= $form->field($model, NewsCommentsSearch::ATTR_USER_ID) ?>

                <?= $form->field($model, NewsCommentsSearch::ATTR_PARENT_ID) ?>

                <?= $form->field($model, NewsCommentsSearch::ATTR_DATE_CREATE) ?>

                <?= $form->field($model, NewsCommentsSearch::ATTR_TEXT) ?>

                <?= $form->field($model, NewsCommentsSearch::ATTR_ACTIVE); ?>

                <div class="form-group">
                    <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
