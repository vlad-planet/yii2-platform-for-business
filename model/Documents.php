<?php

namespace common\models\db;

use common\models\queries\DocumentsQuery;
use common\models\queries\FileQuery;
use common\yii\validators\DateValidator;
use common\yii\validators\ExistValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UniqueValidator;
use common\yii\validators\UuidValidator;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "documents".
 *
 * @property string|null $id
 * @property string $file_id Ссылка на файл
 * @property string|null $date_create Дата добавления записи в БД
 * @property string entity_type Название таблицы, к которой документ привязана
 * @property string $entity_id ID сущности
 *
 * @property Files $file
 *
 * @author Vladislav Bashlykov
 */
class Documents extends ActiveRecord
{
    const TABLE_NAME = 'documents';

    const ATTR_ID           = 'id';
    const ATTR_FILE_ID      = 'file_id';
    const ATTR_DATE_CREATE  = 'date_create';
    const ATTR_ENTITY_TYPE  = 'entity_type';
    const ATTR_ENTITY_ID    = 'entity_id';

    const RELEATION_FILES   = 'files';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return static::TABLE_NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [static::ATTR_ID, UuidValidator::class],
            [static::ATTR_ID, UniqueValidator::class],

            [static::ATTR_FILE_ID, UuidValidator::class],
            [
                static::ATTR_FILE_ID,
                ExistValidator::class,
                ExistValidator::ATTR_TARGET_CLASS => Files::class,
                ExistValidator::ATTR_TARGET_ATTRIBUTE => Files::ATTR_ID
            ],

            [static::ATTR_DATE_CREATE, DateValidator::class, DateValidator::ATTR_FORMAT => DateValidator::FORMAT_DATATIM],

            [static::ATTR_ENTITY_TYPE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_ENTITY_TYPE, RequiredValidator::class],
            [static::ATTR_ENTITY_TYPE, TrimValidator::class],

            [static::ATTR_ENTITY_ID, UuidValidator::class]
       ];
    }

    /**
     * {@inheritdoc}
     * @author Vladislav Bashlykov
     */
    public function attributeLabels()
    {
        return [
            static::ATTR_ID => 'ID',
            static::ATTR_FILE_ID => 'Ссылка на файл',
            static::ATTR_DATE_CREATE => 'Дата добавления записи в БД',
            static::ATTR_ENTITY_TYPE => 'Название таблицы, к которой документ привязана',
            static::ATTR_ENTITY_ID => 'ID сущности'
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery|FileQuery
     *
     * @author Vladislav Bashlykov
     */
    public function getFile()
    {
        return $this->hasOne(Files::Class, [Files::ATTR_ID => static::ATTR_FILE_ID]);
    }

    /**
     * {@inheritdoc}
     * @return DocumentsQuery the active query used by this AR class.
     *
     * @author Vladislav Bashlykov
     */
    public static function find(): DocumentsQuery
    {
        return new DocumentsQuery(get_called_class());
    }
}
