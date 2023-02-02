<?php

namespace frontend\models\notifications;

use common\models\db\Notifications;

/**
 * Класс поиска страниц
 *
 * Class NotificationsSearch
 * @package frontend\models\notifications
 *
 * @author Vladislav Bashlykov
 */
class NotificationsSearch
{
	/**
	 * Поиск страниц
	 *
	 * @param int $limit
	 * @return NotificationsSearchResult
     *
	 * @author Vladislav Bashlykov
	 */
	public function search(int $limit = 20): NotificationsSearchResult
	{
		$query = Notifications::find()
			->orderBy([Notifications::ATTR_DATE_CREATE => SORT_DESC]);

		return (new NotificationsSearchResult($query, $limit));
	}
}