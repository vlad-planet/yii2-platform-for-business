<?php

namespace frontend\controllers;

use common\yii\web\Controller;

use frontend\models\actives\ActiveSearch;
use frontend\models\news\NewsSearch;

/**
 * Контроллер представления Index.
 *
 * @author Vladislav Bashlykov
 */
class IndexController extends Controller
{
	const ACTION_INDEX  = 'index';

	/**
	 * Главная страница.
	 *
	 * @return string
	 *
	 * @author Vladislav Bashlykov
	 */
    public function actionIndex(): string
    {
        $model = new ActiveSearch();

        return $this->render(static::ACTION_INDEX, [
            'model'              => $model,
            'newsSearchResult'   => (new NewsSearch())->search(3),
        ]);
    }
}