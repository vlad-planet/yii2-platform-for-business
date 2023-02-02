<?php

use backend\controllers\CountryController;

use backend\controllers\UserController;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\db\UserVerification */
/* @var $userModel common\models\db\Users */

$this->title = 'Добавить верификацию';
$this->params['breadcrumbs'][] = [
	'label' => 'Пользователи',
	'url'   => UserController::getUrlRoute(UserController::ACTION_INDEX)
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
						'model'     => $model,
                        'userModel' => $userModel
					]) ?>
				</div>
			</div>
		</div>
	</div>
</div>
