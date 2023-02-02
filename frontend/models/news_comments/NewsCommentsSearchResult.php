<?php

namespace frontend\models\news_comments;

use common\models\db\NewsComments;
use frontend\core\search\SearchResult;

use Yii;
use yii\db\ActiveRecordInterface;

/**
 * @author Vladislav Bashlykov
 */
class NewsCommentsSearchResult extends SearchResult
{
	/** @var NewsCommentsItem[] */
	public $items;

	/**
	 * Создание модели с данными
     *
	 * @param NewsComments $model
	 * @return NewsCommentsItem
     * @throws
     *
	 * @author Vladislav Bashlykov
	 */

	public function createModel(ActiveRecordInterface $model): NewsCommentsItem
	{
		$result = new NewsCommentsItem();

        $result->id          = $model->id;
        $result->news_id     = $model->news_id;
        $result->user_id     = $model->user_id;
        $result->parent_id   = $model->parent_id;
        $result->date_create = Yii::$app->formatter->asDate($model->date_create,'php:d.m.Y');
        $result->text        = $model->text;
        $result->author      = $model->users->first_name.' '.$model->users->last_name;

		return $result;
	}
}