<?php

namespace frontend\models\news;

use common\models\db\News;
use frontend\core\search\SearchView;
use yii\db\ActiveRecordInterface;

/**
 * Просмотр новости
 * @author Pavel Scherbich
 */
class NewsSearchView extends SearchView
{
	/**
	 * @var NewsItem
	 */
	public $result;

	/**
	 * @param News $model
	 *
	 * @return NewsItem
	 * @author Pavel Scherbich
	 */
	public function createModel(ActiveRecordInterface $model): NewsItem
	{
		$result = new NewsItem;

		$result->id          = $model->id;
		$result->title       = $model->title;
		$result->text        = $model->text;
		$result->alias       = $model->alias;
		$result->date_create = $model->date_create;

		return $result;
	}
}