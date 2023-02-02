<?php

use backend\controllers\NewsCommentsController;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\db\NewsComments */

$this->title = 'Редактирование: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Комментарии к новостям', 'url' => [NewsCommentsController::ACTION_INDEX]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <h1><?= Html::encode($this->title) ?></h1>

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
