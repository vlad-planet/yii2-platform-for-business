<?php

namespace frontend\models\dynamic_pages;

use common\models\db\DynamicPages;

/**
 * Класс поиска страниц
 *
 * Class DynamicPagesSearch
 * @package frontend\models\dynamic_pages
 *
 * @author Vladislav Bashlykov
 */
class DynamicPagesSearch
{
	/**
	 * Поиск страниц
	 *
	 * @param int $limit
	 *
	 * @return DynamicPagesSearchResult
     *
	 * @author Vladislav Bashlykov
	 */
	public function search(int $limit = 20): DynamicPagesSearchResult
	{
		$query = DynamicPages::find()
			->isActive()
			->orderBy([DynamicPages::ATTR_DATE_CREATE => SORT_DESC]);

		return (new DynamicPagesSearchResult($query, $limit));
	}
}