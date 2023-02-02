<?php

namespace frontend\models\passports_data;

use common\yii\validators\DateValidator;
use common\yii\validators\IntegerValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UniqueValidator;
use common\yii\validators\UuidValidator;

use yii\base\Model;

/**
 * Форма Пасспортные данные
 *
 * @author Vladislav Bashlykov
 */
class PassportsDataForm extends Model
{
    /** @var string */
    public $id;
    const ATTR_ID = 'id';
	
    /** @var string */
    public $bday;
    const ATTR_BDAY = 'bday';
	
    /** @var string */
    public $serial;
    const ATTR_SERIAL = 'serial';
	
    /** @var int */
    public $number;
    const ATTR_NUMBER = 'number';
	
    /** @var string */
    public $issue_date;
    const ATTR_ISSUE_DATE = 'issue_date';
	
    /** @var string */
    public $issue_id;
    const ATTR_ISSUE_ID = 'issue_id';
	
    /** @var string */
    public $place_bday;
    const ATTR_PLACE_BDAY = 'place_bday';
	
    /** @var string */
    public $place_registration;
    const ATTR_PLACE_REGISTRATION = 'place_registration';
	
    /** @var int */
    public $gender;
    const ATTR_GENDER = 'gender';

    const GENDER_FEMALE     = 1;
    const GENDER_MALE   	= 0;
    
    /**
     * {@inheritdoc}
     *
     * @author Vladislav Bashlykov
     */
    public function rules(): array
    {
        return [
            [static::ATTR_ID, UuidValidator::class],
            [static::ATTR_ID, UniqueValidator::class],

			[
				static::ATTR_BDAY,
				DateValidator::class,
				DateValidator::ATTR_FORMAT => DateValidator::DEFAULT_FORMAT
			],

            [static::ATTR_SERIAL, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH_100],
            [static::ATTR_SERIAL, RequiredValidator::class],
            [static::ATTR_SERIAL, TrimValidator::class],

            [static::ATTR_NUMBER, IntegerValidator::class],

			[
				static::ATTR_ISSUE_DATE,
				DateValidator::class,
				DateValidator::ATTR_FORMAT => DateValidator::DEFAULT_FORMAT
			],

            [static::ATTR_ISSUE_ID, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH_100],
            [static::ATTR_ISSUE_ID, RequiredValidator::class],
            [static::ATTR_ISSUE_ID, TrimValidator::class],

			[static::ATTR_PLACE_BDAY, StringValidator::class],
            [static::ATTR_PLACE_BDAY, RequiredValidator::class],
            [static::ATTR_PLACE_BDAY, TrimValidator::class],

			[static::ATTR_PLACE_REGISTRATION, StringValidator::class],
            [static::ATTR_PLACE_REGISTRATION, RequiredValidator::class],
            [static::ATTR_PLACE_REGISTRATION, TrimValidator::class],

            [
                static::ATTR_GENDER,
                IntegerValidator::class,
                IntegerValidator::ATTR_MIN => static::GENDER_MALE,
                IntegerValidator::ATTR_MAX => static::GENDER_FEMALE
            ]
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @author Vladislav Bashlykov
     */
    public function attributeLabels(): array
    {
        return [
			static::ATTR_ID					=> 'id',
			static::ATTR_BDAY				=> 'Дата рождения в паспорте',
			static::ATTR_SERIAL   		    => 'Серия паспорта',
			static::ATTR_NUMBER				=> 'Номер паспорта',
			static::ATTR_ISSUE_DATE			=> 'Дата выдачи паспорта',
			static::ATTR_ISSUE_ID   		=> 'Код подразделения',
			static::ATTR_PLACE_BDAY			=> 'Место рождения',
			static::ATTR_PLACE_REGISTRATION	=> 'Место регистрации',
			static::ATTR_GENDER				=> 'Пол'
        ];
    }

    /**
     * Сохранение формы в БД
     *
     * @return bool
     *
     * @author Vladislav Bashlykov
     */
    public function save(): bool
    {
        $result = false;

        if (true === $this->validate()) {
            $PassportsDataService = new PassportsDataService();
            $result = $PassportsDataService->save($this);
        }

        return $result;
    }
}