<?php

namespace frontend\models\dynamic_pages;

use common\models\db\DynamicPages;
use frontend\core\search\SearchView;
use yii\db\ActiveRecordInterface;

/**
 * Модель детального просмотра
 *
 * @author Vladislav Bashlykov
 */
class DynamicPagesSearchView extends SearchView
{
	/**
	 * @param DynamicPages $model
	 *
	 * @return DynamicPagesItem
     *
	 * @author Vladislav Bashlykov
	 */
	public function createModel(ActiveRecordInterface $model): DynamicPagesItem
	{
		$result = new DynamicPagesItem;

		$result->title          = $model->title;
		$result->text           = $model->text;
		$result->alias          = $model->alias;
		$result->date_create    = $model->date_create;

		return $result;
	}
}