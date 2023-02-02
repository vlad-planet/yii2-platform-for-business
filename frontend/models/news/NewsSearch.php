<?php

namespace frontend\models\news;

use common\models\db\News;

/**
 * Класс для поиска новостей
 *
 * Class NewsView
 * @package frontend\modules\news\model\news
 *
 * @author Maxim Podberezhskiy
 */
class NewsSearch
{
	/**
	 * Поиск новостей
	 *
	 * @param int $limit
	 *
	 * @return NewsSearchResult
	 * @author Pavel Scherbich
	 */
	public function search(int $limit = 20): NewsSearchResult
	{
		$query = News::find()
			->with(News::RELATION_FILE)
			->isActive()
			->orderBy([News::ATTR_DATE_CREATE => SORT_DESC]);

		return (new NewsSearchResult($query, $limit));
	}
}