<?php

namespace frontend\modules\personal\controllers;

use common\yii\web\Controller;

use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * @author Pavel Scherbich
 */
class BaseController extends Controller
{
	/**
	 * {@inheritdoc}
	 *
	 * @author Maxim Podberezhskiy
	 */
	public function behaviors(): array
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
				'denyCallback' => function () {
					throw new ForbiddenHttpException();
				},
			],
		];
	}
}