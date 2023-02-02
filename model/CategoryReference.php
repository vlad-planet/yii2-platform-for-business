<?php

namespace common\models\db;

use common\models\queries\CategoryReferenceQuery;

use common\yii\validators\DateValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UniqueValidator;
use common\yii\validators\UuidValidator;

use yii\db\ActiveRecord;

/**
 * Модель БД 'Справочник категорий'
 *
 * @property string $id ID записи
 * @property string $name Наименование
 * @property string|null $date_create Дата и время добавления
 *
 * @author Vladislav Bashlykov
 */
class CategoryReference extends ActiveRecord
{
    const TABLE_NAME = 'category_reference';

    const ATTR_ID          = 'id';
    const ATTR_NAME        = 'name';
    const ATTR_DATE_CREATE = 'date_create';
    /**
     * Наименование таблицы
     *
     * @return string
     *
     * @author Vladislav Bashlykov
     */
    public static function tableName(): string
    {
        return static::TABLE_NAME;
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
            [static::ATTR_ID, UuidValidator::class],
            [static::ATTR_ID, UniqueValidator::class],

            [static::ATTR_NAME, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_NAME, RequiredValidator::class],
            [static::ATTR_NAME, TrimValidator::class],

            [static::ATTR_DATE_CREATE, DateValidator::class, DateValidator::ATTR_FORMAT => DateValidator::FORMAT_DATATIM],
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
    public function attributeLabels()
    {
        return [

            static::ATTR_ID=> 'ID',
            static::ATTR_NAME => 'Наименование',
            static::ATTR_DATE_CREATE => 'Дата и время добавления',
        ];
    }

    /**
     * Формирование запроса
     *
     * {@inheritdoc}
     * @return CategoryReferenceQuery the active query used by this AR class.
     *
     * @author Vladislav Bashlykov
     */
    public static function find()
    {
        return new CategoryReferenceQuery(get_called_class());
    }
}