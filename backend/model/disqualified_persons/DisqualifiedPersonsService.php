<?php

namespace backend\models\disqualified_persons;

use common\models\db\DisqualifiedPersons;
use yii\helpers\Html;

/**
 * Сервис работы с формой 'Реестр дисквалифицированных лиц'
 *
 * Class DisqualifiedPersonsService
 * @package backend\models\disqualified_persons
 *
 * @author Vladislav Bashlykov
 */
class DisqualifiedPersonsService
{
    /**
     * @var DisqualifiedPersons
     */
    private $model;

    /**
     * @var DisqualifiedPersonsForm
     */
    private $form;

    /**
     * При инициализации класса
     *
     * @param DisqualifiedPersonsForm $form
     *
     * @author Vladislav Bashlykov
     */
    public function __construct(DisqualifiedPersonsForm $form)
    {
        $this->model = $form->_model ?? new DisqualifiedPersons;
        $this->form  = $form;
    }

    /**
     * Сохранение данных в БД
     *
     * @return bool
     *
     * @author Vladislav Bashlykov
     */
    public function save(): bool
    {
        $this->model->number_in_reestr = Html::encode($this->form->number_in_reestr);
        $this->model->fio              = Html::encode($this->form->fio);
        $this->model->b_day            = Html::encode($this->form->b_day);
        $this->model->b_place          = Html::encode($this->form->b_place);
        $this->model->company          = Html::encode($this->form->company);
        $this->model->inn              = Html::encode($this->form->inn);
        $this->model->position         = Html::encode($this->form->position);
        $this->model->article_code     = Html::encode($this->form->article_code);
        $this->model->body_title       = Html::encode($this->form->body_title);
        $this->model->judge_position   = Html::encode($this->form->judge_position);
        $this->model->judge_fio        = Html::encode($this->form->judge_fio);
        $this->model->date_start       = Html::encode($this->form->date_start);
        $this->model->date_end         = Html::encode($this->form->date_end);

        return $this->model->save();
    }
}