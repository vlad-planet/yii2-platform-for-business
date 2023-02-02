<?php

namespace frontend\models\employees;

use common\models\db\ActiveEmployees;
use frontend\core\search\SearchView;

use Yii;
use yii\db\ActiveRecordInterface;

/**
 * Модель детального просмотра
 *
 * @author Vladislav Bashlykov
 */
class EmployeesView extends SearchView
{
	/**
	 * @param ActiveEmployees $model
	 *
	 * @return EmployeesItem
     *
	 * @author Vladislav Bashlykov
     *
     * @throws
	 */
	public function createModel(ActiveRecordInterface $model): EmployeesItem
	{
		$result = new EmployeesItem;

        $result->fio                = $model->fio;
        $result->position           = $model->position;
        $result->department         = $model->department;
        $result->date_create        = Yii::$app->formatter->asDate($model->date_create);
        $result->active_id          = $model->active_id;
        $result->salary             = $model->salary;
        $result->rate               = $model->rate;
        $result->phone              = $model->phone;
        $result->email              = $model->email;
        $result->hire_date          = Yii::$app->formatter->asDate($model->hire_date);
        $result->manager            = $model->manager;
        $result->bonus_avaible      = $model->bonus_avaible;
        $result->phone_compensation = $model->phone_compensation;
        $result->dms                = $model->dms;

		return $result;
	}
}