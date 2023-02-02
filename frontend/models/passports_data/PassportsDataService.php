<?php

namespace frontend\models\passports_data;

use yii\helpers\Html;

/**
 * Сервис работы с формой Пасспортные данные
 *
 * Class PassportsData
 * @package frontend\models\passports-data
 *
 * @author Vladislav Bashlykov
 */
class PassportsDataService
{
    /**
     * Обработка данных и сохранение в БД
     *
     * @param PassportsDataForm $form
     * @return bool
     *
     * @author Vladislav Bashlykov
     */
    public function save(PassportsDataForm $form): bool
    {
        $model = $form->_model ?? new PassportsDataForm;

        $model->bday               = $form->bday;
        $model->serial             = Html::encode($form->serial);
        $model->number             = Html::encode($form->number);
        $model->issue_date         = $form->issue_date;
        $model->issue_id           = $form->issue_id;
        $model->place_bday         = Html::encode($form->place_bday);
        $model->place_registration = Html::encode($form->place_registration);
        $model->gender             = $form->gender;

        return $model->save();
    }
}