<?php

namespace frontend\models\employees;

use common\models\db\ActiveEmployees;
use common\models\db\UserActives;

use common\yii\validators\DateValidator;
use common\yii\validators\DefaultValueValidator;
use common\yii\validators\ExistValidator;
use common\yii\validators\FloatValidator;
use common\yii\validators\IntegerValidator;
use common\yii\validators\NumberValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UuidValidator;

use yii\base\Model;
use yii\db\StaleObjectException;

/**
 * Модель данных для формы 'Сотрудники актива'
 *
 * @author Vladislav Bashlykov
 */
class EmployeesForm extends Model
{
    /** @var string */
    public $fio;
    const ATTR_FIO = 'fio';

    /** @var string */
    public $position;
    const ATTR_POSITION = 'position';

    /** @var string */
    public $department;
    const ATTR_DEPARTMENT = 'department';

    /** @var string */
    public $date_create;
    const ATTR_DATE_CREATE = 'date_create';

    /** @var string */
    public $active_id;
    const ATTR_ACTIVE_ID = 'active_id';

    /** @var integer */
    public $salary;
    const ATTR_SALARY = 'salary';

    /** @var float */
    public $rate;
    const ATTR_RATE = 'rate';

    /** @var string */
    public $phone;
    const ATTR_PHONE = 'phone';

    /** @var string */
    public $email;
    const ATTR_EMAIL = 'email';

    /** @var string */
    public $hire_date;
    const ATTR_HIRE_DATE = 'hire_date';

    /** @var string */
    public $manager;
    const ATTR_MANAGER = 'manager';

    /** @var integer */
    public $bonus_avaible;
    const ATTR_BONUS_AVAIBLE = 'bonus_avaible';

    /** @var integer */
    public $phone_compensation;
    const ATTR_PHONE_COMPINSATION = 'phone_compensation';

    /** @var integer */
    public $dms;
    const ATTR_DMS = 'dms';

    const BONUS_AVAIBLE_TRUE  = 1;
    const BONUS_AVAIBLE_FALSE = 0;

    const PHONE_COMPINSATION_TRUE  = 1;
    const PHONE_COMPINSATION_FALSE = 0;

    const DMS_TRUE  = 1;
    const DMS_FALSE = 0;

    /** @var ActiveEmployees  */
    public $_model;

    /**
     * При инициализации класса
     *
     * @param ActiveEmployees|null $model
     * @param array $config
     * @throws
     *
     * @author Vladislav Bashlykov
     */
    public function __construct(ActiveEmployees $model = null, array $config = [])
    {
        if (null !== $model) {
            $this->fio                = $model->fio;
            $this->position           = $model->position;
            $this->department         = $model->department;
            $this->active_id          = $model->active_id;
            $this->salary             = $model->salary;
            $this->rate               = $model->rate;
            $this->phone              = $model->phone;
            $this->email              = $model->email;
            $this->hire_date          = $model->hire_date;
            $this->manager            = $model->manager;
            $this->bonus_avaible      = $model->bonus_avaible;
            $this->phone_compensation = $model->phone_compensation;
            $this->dms                = $model->dms;

            $this->_model  = $model;
        }

        parent::__construct($config);
    }

    /**
     * Правила валидации данных
     *
     * {@inheritdoc}
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function rules(): array
    {
        return [

            [static::ATTR_FIO, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_FIO, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_FIO).' не заполено'],
            [static::ATTR_FIO, TrimValidator::class],

            [static::ATTR_POSITION, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_POSITION, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_POSITION).' не заполено'],
            [static::ATTR_POSITION, TrimValidator::class],

            [static::ATTR_DEPARTMENT, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_DEPARTMENT, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_DEPARTMENT).' не заполено'],
            [static::ATTR_DEPARTMENT, TrimValidator::class],

            [static::ATTR_DATE_CREATE, DateValidator::class, DateValidator::ATTR_FORMAT => DateValidator::FORMAT_DATATIM],

            [static::ATTR_ACTIVE_ID, UuidValidator::class],
            [static::ATTR_ACTIVE_ID, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_ACTIVE_ID).' не заполено'],
            [
                static::ATTR_ACTIVE_ID,
                ExistValidator::class,
                ExistValidator::ATTR_TARGET_CLASS => UserActives::class,
                ExistValidator::ATTR_TARGET_ATTRIBUTE => UserActives::ATTR_ID
            ],

            [static::ATTR_SALARY, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_SALARY).' не заполено'],
            [static::ATTR_SALARY, IntegerValidator::class],

            [static::ATTR_RATE, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_RATE).' не заполено'],
            [static::ATTR_RATE, FloatValidator::class],

            [static::ATTR_PHONE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_PHONE, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_PHONE).' не заполено'],
            [static::ATTR_PHONE, TrimValidator::class],

            [static::ATTR_EMAIL, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_EMAIL, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_EMAIL).' не заполено'],
            [static::ATTR_EMAIL, TrimValidator::class],

            [static::ATTR_HIRE_DATE, DateValidator::class, DateValidator::ATTR_FORMAT => DateValidator::DEFAULT_FORMAT],
            [static::ATTR_HIRE_DATE, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE =>  $this->getAttributeLabel(static::ATTR_HIRE_DATE).' не заполено'],

            [static::ATTR_MANAGER, UuidValidator::class],
            [static::ATTR_MANAGER, DefaultValueValidator::class, DefaultValueValidator::ATTR_VALUE => NULL],

            [
                static::ATTR_BONUS_AVAIBLE,
                IntegerValidator::class,
                NumberValidator::ATTR_MIN => static::BONUS_AVAIBLE_FALSE,
                NumberValidator::ATTR_MAX => static::BONUS_AVAIBLE_TRUE
            ],

            [
                static::ATTR_PHONE_COMPINSATION,
                IntegerValidator::class,
                NumberValidator::ATTR_MIN => static::PHONE_COMPINSATION_FALSE,
                NumberValidator::ATTR_MAX => static::PHONE_COMPINSATION_TRUE
            ],

            [
                static::ATTR_DMS,
                IntegerValidator::class,
                NumberValidator::ATTR_MIN => static::DMS_FALSE,
                NumberValidator::ATTR_MAX => static::DMS_TRUE
            ],
        ];
    }

    /**
     * Наименование атрибутов
     *
     * {@inheritdoc}
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function attributeLabels(): array
    {
        return [
            static::ATTR_FIO                => 'ФИО сотрудника',
            static::ATTR_POSITION           => 'Должность',
            static::ATTR_DEPARTMENT         => 'Подразделение',
            static::ATTR_DATE_CREATE        => 'Дата создания',
            static::ATTR_ACTIVE_ID          => 'Актив',
            static::ATTR_SALARY             => 'Зарплата',
            static::ATTR_RATE               => 'Ставка зарплаты',
            static::ATTR_PHONE              => 'Телефон',
            static::ATTR_EMAIL              => 'Email',
            static::ATTR_HIRE_DATE          => 'Дата приёма на работу',
            static::ATTR_MANAGER            => 'Руководитель',
            static::ATTR_BONUS_AVAIBLE      => 'Наличие премии',
            static::ATTR_PHONE_COMPINSATION => 'Компенсация мобильной связи',
            static::ATTR_DMS                => 'ДМС',
        ];
    }

    /**
     * Сохранение данных в БД
     *
     * @return bool
     * @throws StaleObjectException
     *
     * @author Vladislav Bashlykov
     */
    public function save(): bool
    {
        $result = false;

        if (true === $this->validate()) {
            $model = new EmployeesService();
            $result = $model->save($this);
        }

        return $result;
    }
}