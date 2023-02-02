<?php

namespace frontend\models\notifications;

use common\models\db\Notifications;
use frontend\core\search\SearchResult;

use yii;
use yii\db\ActiveRecordInterface;

/**
 * @author Vladislav Bashlykov
 */
class NotificationsSearchResult extends SearchResult
{
	/** @var NotificationsItem[] */
	public $items;

	/**
	 * Создание модели с данными
     *
	 * @param Notifications $model
	 * @return NotificationsItem
     * @throws
     *
	 * @author Vladislav Bashlykov
	 */

	public function createModel(ActiveRecordInterface $model): NotificationsItem
	{
		$result = new NotificationsItem();

		$result->user_id            = $model->user_id ;
        $result->date_create        = Yii::$app->formatter->asDate($model->date_create);
        $result->date_view          = Yii::$app->formatter->asDate($model->date_view);
        $result->text               = substr($model->text, 0, 50);

		return $result;
	}
}