<?php

use backend\controllers\DisqualifiedPersonsController;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\disqualified_persons\DisqualifiedPersonsForm */

$this->title = 'Редактирование: ' . $model->number_in_reestr;
$this->params['breadcrumbs'][] = ['label' => 'Реестр дисквалифицированных лиц', 'url' => [DisqualifiedPersonsController::ACTION_INDEX]];
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
