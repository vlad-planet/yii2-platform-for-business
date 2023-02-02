<?php

namespace frontend\models\employees;

use common\models\db\ActiveEmployees;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\db\StaleObjectException;

/**
 * Сервис работы с формой 'Сотрудники актива'
 *
 * Class ActiveEmployees
 * @package frontend\models\employees
 *
 * @author Vladislav Bashlykov
 */
class EmployeesService
{
    /**
     * Сохранение данных в БД
     *
     * @param EmployeesForm $form
     * @return bool
     *
     * @author Vladislav Bashlykov
     */
    public function save(EmployeesForm $form): bool
    {
        $model = $form->_model ?? new ActiveEmployees();

        $model->fio                = Html::encode($form->fio);
        $model->position           = Html::encode($form->position);
        $model->department         = Html::encode($form->department);
        $model->active_id          = Html::encode($form->active_id);
        $model->salary             = Html::encode($form->salary);
        $model->rate               = Html::encode($form->rate);
        $model->phone              = Html::encode($form->phone);
        $model->email              = Html::encode($form->email);
        $model->hire_date          = Html::encode($form->hire_date);
        $model->manager            = $form->manager;
        $model->bonus_avaible      = $form->bonus_avaible;
        $model->phone_compensation = $form->phone_compensation;
        $model->dms                = $form->dms;

        return $model->save();
    }

    /**
     * Список сотрудников
     *
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public static function getListForSelect(): array
    {
        $cache = Yii::$app->cache;
        $key = 'employees_list';

        $list = $cache->get($key);

        if ($list === false) {
            $list = $cache->getOrSet($key, function () {
                return ArrayHelper::map(ActiveEmployees::find()->all(), ActiveEmployees::ATTR_ID, ActiveEmployees::ATTR_FIO);
            }, 3600);
        }

        return $list;
    }
}