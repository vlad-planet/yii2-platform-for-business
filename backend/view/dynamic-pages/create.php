<?php

use backend\controllers\DynamicPagesController;

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\db\DynamicPages */

$this->title = 'Создать страницу';
$this->params['breadcrumbs'][] = [
	'label' => 'Динамические страницы',
	'url'   => [DynamicPagesController::ACTION_INDEX]
];
$this->params['breadcrumbs'][] = $this->title;
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
