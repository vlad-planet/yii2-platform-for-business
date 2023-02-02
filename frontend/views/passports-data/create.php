<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\db\PassportsData */

$this->title = 'Создание паспортных данных';
?>
<div class="passports-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
