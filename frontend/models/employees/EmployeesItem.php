<?php

namespace frontend\models\employees;

use frontend\core\search\SearchItemInterface;

/**
 * Сущность 'Сотрудники актива'
 *
 * Class ActiveEmployeesItem
 *
 * @package frontend\models\employees
 *
 * @property string $id
 * @property string $fio
 * @property string $position
 * @property string $department
 * @property string $date_create
 * @property string $active_id
 * @property integer $salary
 * @property float $rate
 * @property string $phone
 * @property string $email
 * @property string $hire_date
 * @property string $manager
 * @property integer $bonus_avaible
 * @property integer $phone_compensation
 * @property integer $dms
 *
 * @author Vladislav Bashlykov
 */
class EmployeesItem implements SearchItemInterface
{
	/**
	 * ID записи
	 * @var string
	 */
	public $id;

	/**
	 * ФИО сотрудника
	 * @var string
	 */
    public $fio;

	/**
	 * Должность
	 * @var string
	 */
    public $position;

	/**
	 * Подразделение
	 * @var string
	 */
    public $department;

	/**
	 * Дата создания
	 * @var string
	 */
	public $date_create;

    /**
     * ID актива
     * @var string
     */
    public $active_id;

    /**
     * Зарплата
     * @var integer
     */
    public $salary;

    /**
     * Ставка зарплаты
     * @var float
     */
    public $rate;

    /**
     * Телефон
     * @var string
     */
    public $phone;

    /**
     * Email
     * @var string
     */
    public $email;

    /**
     * Дата приёма на работу
     * @var string
     */
    public $hire_date;

    /**
     * ID руководителя
     * @var string
     */
    public $manager;

    /**
     * IНаличие премии (0 - нет; 1 - да)
     * @var integer
     */
    public $bonus_avaible;

    /**
     * Компенсация мобильной связи (0 - нет; 1 - да)
     * @var integer
     */
    public $phone_compensation;

    /**
     * ДМС (0 - нет; 1 - да)
     * @var integer
     */
    public $dms;
}