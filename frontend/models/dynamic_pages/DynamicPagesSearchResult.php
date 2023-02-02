<?php

namespace frontend\models\dynamic_pages;

use common\models\db\DynamicPages;

use frontend\controllers\DynamicPagesController;
use frontend\core\search\SearchResult;

use yii;
use yii\db\ActiveRecordInterface;
use yii\helpers\Url;

/**
 * @author Vladislav Bashlykov
 */
class DynamicPagesSearchResult extends SearchResult
{
	/** @var DynamicPagesItem[] */
	public $items;

	/**
	 * Создание модели с данными
     *
	 * @param DynamicPages $model
	 * @return DynamicPagesItem
     * @throws
     *
	 * @author Vladislav Bashlykov
	 */
	public function createModel(ActiveRecordInterface $model): DynamicPagesItem
	{
		$result = new DynamicPagesItem();

		$result->title       = $model->title;
		$result->text        = $model->text;
		$result->alias       = $model->alias;
		$result->date_create = Yii::$app->formatter->asDate($model->date_create);
		$result->detail_url  = Url::to(DynamicPagesController::getUrlRoute(DynamicPagesController::ACTION_VIEW, [DynamicPagesController::PARAM_ALIAS => $model->alias]));

		return $result;
	}
}