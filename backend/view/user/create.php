<?php

use backend\controllers\UserController;

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\models\user\UserForm */
/* @var $userModel \common\models\db\Users */

$this->title = 'Создать пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => [UserController::ACTION_INDEX]];
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
