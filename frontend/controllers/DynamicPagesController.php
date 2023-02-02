<?php

namespace frontend\controllers;

use common\models\db\DynamicPages;
use common\yii\web\Controller;

use frontend\models\dynamic_pages\DynamicPagesSearch;

use frontend\models\dynamic_pages\DynamicPagesSearchView;
use yii\web\NotFoundHttpException;

/**
 * Контроллер для работы с 'Динимические страницы'
 *
 * Class NewsController
 * @package frontend\controller
 *
 * @author Vladislav Bashlykov
 */
class DynamicPagesController extends Controller
{
	const ACTION_INDEX = 'index';
	const ACTION_VIEW  = 'view';

	const PARAM_ALIAS = 'alias';

	/**
	 * Индексная страница
     *
	 * @return string
     *
	 * @author Vladislav Bashlykov
	 */
	public function actionIndex(): string
	{
		return $this->render(static::ACTION_INDEX, [
			'result' => (new DynamicPagesSearch())->search(1)
		]);
	}

	/**
	 * Детальный просмотр
     *
	 * @param string $alias
	 * @return string
     * @throws NotFoundHttpException
     *
	 * @author Vladislav Bashlykov
	 */
	public function actionView(string $alias): string
	{
		return $this->render(static::ACTION_VIEW, [
			'model' => new DynamicPagesSearchView($this->findModelByAlias($alias)),
		]);
	}

	/**
     * Формирования запроса модели по Алиасу
     *
	 * @param string $alias
	 * @return DynamicPages
	 * @throws NotFoundHttpException
	 *
	 * @author Vladislav Bashlykov
	 */
	protected function findModelByAlias(string $alias): DynamicPages
	{
		if (($model = DynamicPages::findOne([DynamicPages::ATTR_ALIAS => $alias])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}