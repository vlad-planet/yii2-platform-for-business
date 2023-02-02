<?php

namespace frontend\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
	public function __construct($id, $module, array $config = [])
	{
		parent::__construct($id, $module, $config);
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
                'layout' => 'error'
			]
		];
	}
}