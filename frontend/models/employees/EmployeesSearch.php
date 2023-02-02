<?php

namespace frontend\models\employees;

use common\models\db\ActiveEmployees;

/**
 * Класс поиска страниц
 *
 * Class ActiveEmployeesSearch
 * @package frontend\models\employees
 *
 * @author Vladislav Bashlykov
 */
class EmployeesSearch
{
	/**
	 * Поиск страниц
	 *
	 * @param int $limit
	 *
	 * @return EmployeesSearchResult
     *
	 * @author Vladislav Bashlykov
	 */
	public function search(int $limit = 20): EmployeesSearchResult
	{
		$query = ActiveEmployees::find()
			->orderBy([ActiveEmployees::ATTR_DATE_CREATE => SORT_DESC]);

		return (new EmployeesSearchResult($query, $limit));
	}
}