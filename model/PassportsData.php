<?php

namespace common\models\db;

use common\models\queries\PassportsDataQuery;
use common\yii\validators\DateValidator;
use common\yii\validators\IntegerValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UniqueValidator;
use common\yii\validators\UuidValidator;

use yii\db\ActiveRecord;

/**
 * Модель Паспортных данных
 *
 * @property string	$id
 * @property string	$bday Дата рождения в паспорте
 * @property string	$serial Серия паспорта
 * @property int	$number Номер паспорта
 * @property string	$issue_date Дата выдачи паспорта
 * @property string	$issue_id Код подразделения
 * @property string	$place_bday Место рождения
 * @property string	$place_registration Место регистрации
 * @property int	$gender Пол. 0 - М; 1 - Ж;
 *
 * @author Vladislav Bashlykov
 */
class PassportsData extends ActiveRecord
{
    const TABLE_NAME = 'passports_data';

    const ATTR_ID					= 'id';
    const ATTR_BDAY					= 'bday';
    const ATTR_SERIAL   		    = 'serial';
    const ATTR_NUMBER				= 'number';
    const ATTR_ISSUE_DATE			= 'issue_date';
    const ATTR_ISSUE_ID   		    = 'issue_id';
    const ATTR_PLACE_BDAY			= 'place_bday';	
    const ATTR_PLACE_REGISTRATION	= 'place_registration';
    const ATTR_GENDER				= 'gender';

    const GENDER_FEMALE     = 1;	
    const GENDER_MALE   	= 0; 

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return static::TABLE_NAME;
    }

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
     * Пол. 0 - М; 1 - Ж;
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function getGenderVariants()
    {
        return [
            static::GENDER_FEMALE	=> 'Ж',
            static::GENDER_MALE		=> 'М'
        ];
    }

    /**
     * Получение текстового маркера значения поля gender
     * @return string|null
     *
     * @author Vladislav Bashlykov
     */
    public function getGenderVariantsLabel(): ?string
    {
        return (static::getGenderVariants())[$this->gender] ?? null;
    }

    /**
     * {@inheritdoc}
     * @return PassportsDataQuery the active query used by this AR class.
     *
     * @author Vladislav Bashlykov
     */
    public static function find(): PassportsDataQuery
    {
        return new PassportsDataQuery(get_called_class());
    }
}