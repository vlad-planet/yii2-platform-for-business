<?php

namespace frontend\modules\personal\models\personal;

use common\models\db\Users;
use common\models\db\VerifyProfileRequest;

use common\yii\validators\DateValidator;
use common\yii\validators\DefaultValueValidator;
use common\yii\validators\ExistValidator;
use common\yii\validators\FileValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UuidValidator;

use yii\base\Model;
use yii\db\StaleObjectException;

/**
 * Модель данных для формы 'Профиль персоны'
 *
 * Class PersonalProfileForm
 * @package frontend\modules\personal\models\personal
 *
 * @author Vladislav Bashlykov
 */
class PersonalProfileForm extends Model
{
    /** @var string ID */
    public $user_id;
    const ATTR_USER_ID = 'user_id';

    /** @var string Гражданство */
    public $passport_nationality;
    const ATTR_PASSPORT_NATIONALITY = 'passport_nationality';

    /** @var string Номер паспорта */
    public $passport_number;
    const ATTR_PASSPORT_NUMBER = 'passport_number';

    /** @var string Дата выдачи паспорта */
    public $passport_date_issue;
    const ATTR_PASSPORT_DATE_ISSUE = 'passport_date_issue';

    /** @var string Номер отделения */
    public $passport_office;
    const ATTR_PASSPORT_OFFICE = 'passport_office';

    /** @var string Кем выдан паспорт */
    public $passport_whom_issued;
    const ATTR_PASSPORT_WHOM_ISSUED = 'passport_whom_issued';

    /** @var string Место рождения */
    public $passport_birth_place;
    const ATTR_PASSPORT_BIRTH_PLACE = 'passport_birth_place';

    /** @var string Дата рождения */
    public $passport_bday_place;
    const ATTR_PASSPORT_BDAY_PLACE = 'passport_bday_place';

    /** @var string Файл паспорта */
    public $passport_file;
    const ATTR_PASSPORT_FILE = 'passport_file';

    /** @var string Адрес проживания */
    public $passport_resident_address;
    const ATTR_PASSPORT_RESIDENT_ADDRESS = 'passport_resident_address';

    /** @var string Фактический адрес проживания */
    public $passport_fact_resident_address;
    const ATTR_PASSPORT_FACT_RESIDENT_ADDRESS = 'passport_fact_resident_address';

    /** @var integer Совподает ли адрес проживания с фактическим */
    public $passport_is_same_address;
    const ATTR_PASSPORT_IS_SAME_ADDRESS = 'passport_is_same_address';

    /** @var string ИНН */
    public $personal_data_inn;
    const ATTR_PERSONAL_DATA_INN = 'personal_data_inn';

    /** @var string СНИЛС */
    public $personal_data_snils;
    const ATTR_PERSONAL_DATA_SNILS = 'personal_data_snils';

    /** @var string Водительские права */
    public $personal_data_driving_license;
    const ATTR_PERSONAL_DATA_DRIVING_LICENSE = 'personal_data_driving_license';

    /** @var string Дополнительные файлы */
    public $personal_data_additional_files;
    const ATTR_PERSONAL_DATA_ADDITIONAL_FILES = 'personal_data_additional_files';

    /** @var string сообщение */
    const MESSAGE_TRUE = 'Данные отправлены на модерацию';

    /** @var VerifyProfileRequest  */
    public $_model;

    /**
     * При инициализации класса
     *
     * @param VerifyProfileRequest|null $model
     * @param array $config
     * @throws
     *
     * @author Vladislav Bashlykov
     */
    public function __construct(VerifyProfileRequest $model = null, array $config = [])
    {
        if(null !== $model){
            $this->user_id                                 = $model->user_id;

            $this->passport_nationality                    = $model->passport_nationality;
            $this->passport_number                         = $model->passport_number;
            $this->passport_date_issue                     = $model->passport_date_issue;
            $this->passport_office                         = $model->passport_office;
            $this->passport_whom_issued                    = $model->passport_whom_issued;
            $this->passport_birth_place                    = $model->passport_birth_place;
            $this->passport_bday_place                     = $model->passport_bday_place;
            $this->passport_file                           = $model->passport_file;
            $this->passport_resident_address               = $model->passport_resident_address;
            $this->passport_fact_resident_address          = $model->passport_fact_resident_address;

            $this->personal_data_inn                       = $model->personal_data_inn;
            $this->personal_data_snils                     = $model->personal_data_snils;
            $this->personal_data_driving_license           = $model->personal_data_driving_license;
            $this->personal_data_additional_files          = $model->personal_data_additional_files;

            $this->_model = $model;
        }

        parent::__construct($config);
    }

    /** @return string */
    public function formName(): string
    {
        return '';
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

            [static::ATTR_USER_ID, UuidValidator::class],
            [
                static::ATTR_USER_ID,
                ExistValidator::class,
                ExistValidator::ATTR_TARGET_CLASS => Users::class,
                ExistValidator::ATTR_TARGET_ATTRIBUTE => Users::ATTR_ID
            ],

            [static::ATTR_PASSPORT_NATIONALITY, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_PASSPORT_NATIONALITY, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_PASSPORT_NATIONALITY).' не заполено'],
            [static::ATTR_PASSPORT_NATIONALITY, TrimValidator::class],

            [static::ATTR_PASSPORT_NUMBER, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_PASSPORT_NUMBER, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_PASSPORT_NUMBER).' не заполено'],
            [static::ATTR_PASSPORT_NUMBER, TrimValidator::class],

            [static::ATTR_PASSPORT_DATE_ISSUE, DateValidator::class, DateValidator::ATTR_FORMAT => DateValidator::DEFAULT_FORMAT],
            [static::ATTR_PASSPORT_DATE_ISSUE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_PASSPORT_DATE_ISSUE, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_PASSPORT_DATE_ISSUE).' не заполено'],
            [static::ATTR_PASSPORT_DATE_ISSUE, TrimValidator::class],

            [static::ATTR_PASSPORT_OFFICE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_PASSPORT_OFFICE, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_PASSPORT_OFFICE).' не заполено'],
            [static::ATTR_PASSPORT_OFFICE, TrimValidator::class],

            [static::ATTR_PASSPORT_WHOM_ISSUED, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_PASSPORT_WHOM_ISSUED, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_PASSPORT_WHOM_ISSUED).' не заполено'],
            [static::ATTR_PASSPORT_WHOM_ISSUED, TrimValidator::class],

            [static::ATTR_PASSPORT_BDAY_PLACE, DateValidator::class, DateValidator::ATTR_FORMAT => DateValidator::DEFAULT_FORMAT],
            [static::ATTR_PASSPORT_BDAY_PLACE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_PASSPORT_BDAY_PLACE, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_PASSPORT_BDAY_PLACE).' не заполено'],
            [static::ATTR_PASSPORT_BDAY_PLACE, TrimValidator::class],

            [static::ATTR_PASSPORT_BIRTH_PLACE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_PASSPORT_BIRTH_PLACE, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_PASSPORT_BIRTH_PLACE).' не заполено'],
            [static::ATTR_PASSPORT_BIRTH_PLACE, TrimValidator::class],

            [static::ATTR_PASSPORT_FILE, FileValidator::class, FileValidator::ATTR_MAX_SIZE => 1024 * 1024 * 5],
            [static::ATTR_PASSPORT_FILE, DefaultValueValidator::class, DefaultValueValidator::ATTR_VALUE => NULL],

            [static::ATTR_PASSPORT_RESIDENT_ADDRESS, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_PASSPORT_RESIDENT_ADDRESS, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_PASSPORT_RESIDENT_ADDRESS).' не заполено'],
            [static::ATTR_PASSPORT_RESIDENT_ADDRESS, TrimValidator::class],

            [static::ATTR_PASSPORT_FACT_RESIDENT_ADDRESS, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_PASSPORT_FACT_RESIDENT_ADDRESS, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_PASSPORT_FACT_RESIDENT_ADDRESS).' не заполено'],
            [static::ATTR_PASSPORT_FACT_RESIDENT_ADDRESS, TrimValidator::class],

            [static::ATTR_PERSONAL_DATA_INN, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH_20],
            [static::ATTR_PERSONAL_DATA_INN, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_PERSONAL_DATA_INN).' не заполено'],
            [static::ATTR_PERSONAL_DATA_INN, TrimValidator::class],

            [static::ATTR_PERSONAL_DATA_SNILS, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH_20],
            [static::ATTR_PERSONAL_DATA_SNILS, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_PERSONAL_DATA_SNILS).' не заполено'],
            [static::ATTR_PERSONAL_DATA_SNILS, TrimValidator::class],

            [static::ATTR_PERSONAL_DATA_DRIVING_LICENSE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH_20],
            [static::ATTR_PERSONAL_DATA_DRIVING_LICENSE, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => $this->getAttributeLabel(static::ATTR_PERSONAL_DATA_DRIVING_LICENSE).' не заполено'],
            [static::ATTR_PERSONAL_DATA_DRIVING_LICENSE, TrimValidator::class],

            [static::ATTR_PERSONAL_DATA_ADDITIONAL_FILES, FileValidator::class, FileValidator::ATTR_MAX_SIZE => 1024 * 1024 * 5],
            [static::ATTR_PERSONAL_DATA_ADDITIONAL_FILES, DefaultValueValidator::class, DefaultValueValidator::ATTR_VALUE => NULL],
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
            static::ATTR_USER_ID                        => 'ID пользователя',

            static::ATTR_PASSPORT_NATIONALITY           => 'Гражданство',
            static::ATTR_PASSPORT_NUMBER                => 'Номер паспорта',
            static::ATTR_PASSPORT_DATE_ISSUE            => 'Дата выдачи',
            static::ATTR_PASSPORT_OFFICE                => 'Номер отделения',
            static::ATTR_PASSPORT_WHOM_ISSUED           => 'Кем выдан',
            static::ATTR_PASSPORT_BIRTH_PLACE           => 'Место рождения',
            static::ATTR_PASSPORT_BDAY_PLACE            => 'Дата рождения',
            static::ATTR_PASSPORT_FILE                  => 'Файл паспорта',
            static::ATTR_PASSPORT_RESIDENT_ADDRESS      => 'Адрес проживания',
            static::ATTR_PASSPORT_FACT_RESIDENT_ADDRESS => 'Адрес Фактического проживания',
            static::ATTR_PASSPORT_IS_SAME_ADDRESS       => 'Адрес регистрации совпадает с адресом фактического проживания',

            static::ATTR_PERSONAL_DATA_INN              => 'ИНН',
            static::ATTR_PERSONAL_DATA_SNILS            => 'СНИЛС РФ (если есть)',
            static::ATTR_PERSONAL_DATA_DRIVING_LICENSE  => 'Водительское удостоверение',
            static::ATTR_PERSONAL_DATA_ADDITIONAL_FILES => 'Дополнительные файлы'
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
            $model = new PersonalProfileService();
            $result = $model->save($this);
        }

        return $result;
    }
}