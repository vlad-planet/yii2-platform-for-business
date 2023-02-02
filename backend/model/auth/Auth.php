<?php

namespace common\models\db;

use common\models\queries\AuthQuery;

use common\yii\validators\ExistValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UniqueValidator;
use common\yii\validators\UuidValidator;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth".
 *
 * @property string|null $id
 * @property string $user_id Идентификатор пользователя
 * @property string $source Провайдер аутентификации
 * @property string $source_id Идентификатор пользователя в системе провайдера
 *
 * @property Users $user
 */
class Auth extends ActiveRecord
{
    const TABLE_NAME     = 'auth';

    const ATTR_ID        = 'id';
    const ATTR_USER_ID   = 'user_id';
    const ATTR_SOURCE    = 'source';
    const ATTR_SOURCE_ID = 'source_id';

    const RELEATION_USER = 'users';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return static::TABLE_NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() :array
    {
        return [
            [static::ATTR_ID, UuidValidator::class],
            [static::ATTR_ID, UniqueValidator::class],

            [static::ATTR_USER_ID, UuidValidator::class],
            [
                static::ATTR_USER_ID,
                ExistValidator::class,
                ExistValidator::ATTR_TARGET_CLASS => Users::class,
                ExistValidator::ATTR_TARGET_ATTRIBUTE => Users::ATTR_ID
            ],

            [static::ATTR_SOURCE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH_100],
            [static::ATTR_SOURCE, RequiredValidator::class],
            [static::ATTR_SOURCE, TrimValidator::class],

            [static::ATTR_SOURCE_ID, UuidValidator::class],
            [
                static::ATTR_SOURCE_ID,
                ExistValidator::class,
                ExistValidator::ATTR_TARGET_CLASS => Users::class,
                ExistValidator::ATTR_TARGET_ATTRIBUTE => Users::ATTR_ID
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function attributeLabels(): array
    {
        return [
            static::ATTR_ID         => 'ID',
            static::ATTR_USER_ID    => 'Идентификатор пользователя',
            static::ATTR_SOURCE     => 'Провайдер аутентификации',
            static::ATTR_SOURCE_ID  => 'Идентификатор пользователя в системе провайдера',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|AuthQuery
     *
     * @author Vladislav Bashlykov
     */
    public function getUser()
    {
        return $this->hasOne(Users::Class, [Users::ATTR_ID => static::ATTR_USER_ID]);
    }

    /**
     * {@inheritdoc}
     * @return AuthQuery the active query used by this AR class.
     *
     * @author Vladislav Bashlykov
     */
    public static function find(): AuthQuery
    {
        return new AuthQuery(get_called_class());
    }
}
