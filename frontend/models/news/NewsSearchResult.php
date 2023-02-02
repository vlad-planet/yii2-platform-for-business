<?php

namespace frontend\models\news;

use common\models\db\News;
use common\models\service\FileService;
use common\models\service\ImageService;

use frontend\controllers\NewsController;
use frontend\core\search\SearchResult;
use frontend\models\news_comments\NewsCommentsSearch;

use yii;
use yii\db\ActiveRecordInterface;
use yii\helpers\Url;

/**
 * @author Pavel Scherbich
 */
class NewsSearchResult extends SearchResult
{
	/** @var NewsItem[] */
	public $items;

	/**
	 * Создаём модель
	 * @param News $model
	 * @return NewsItem
	 *
	 * @author Maxim Podberezhskiy
	 */
	public function createModel(ActiveRecordInterface $model): NewsItem
	{
		$result = new NewsItem();

        $result->id          = $model->id;
		$result->title       = $model->title;
		$result->text        = $model->text;
		$result->alias       = $model->alias;
		$result->date_create = Yii::$app->formatter->asDate($model->date_create,'php:d.m.Y');
		$result->detail_url  = Url::to(NewsController::getUrlRoute(NewsController::ACTION_VIEW, [NewsController::PARAM_ALIAS => $model->alias]));
        $result->comments_count = $model->comments_count;

		if (!empty($model->file)) {
			$result->image_url = FileService::getPath($model->file);
            $result->image_url_preview = ImageService::resize($model->file, 200,200);
		}

		return $result;
	}
}