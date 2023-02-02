<?php

namespace frontend\models\auth;

use common\yii\validators\CompareValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;

use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{

    /** @var string */
    public $password;
    const ATTR_PASSWORD = 'password';

    /** @var string */
    public $password_confirm;
    const ATTR_PASSWORD_CONFIRM = 'password_confirm';

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [static::ATTR_PASSWORD, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => 'Поле обязательно для заполнения'],
            [static::ATTR_PASSWORD, TrimValidator::class],
            [
                static::ATTR_PASSWORD,
                StringValidator::class,
                StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH,
                StringValidator::ATTR_MIN => 8
            ],

            [static::ATTR_PASSWORD_CONFIRM, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => 'Поле обязательно для заполнения'],
            [static::ATTR_PASSWORD_CONFIRM, TrimValidator::class],
            [
                static::ATTR_PASSWORD_CONFIRM,
                StringValidator::class,
                StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH,
                StringValidator::ATTR_MIN => 8
            ],
            [
                static::ATTR_PASSWORD_CONFIRM,
                CompareValidator::class,
                CompareValidator::ATTR_COMPARE_ATTRIBUTE => static::ATTR_PASSWORD
            ],
        ];
    }

    /**
     * @return string[]
     *
     * @author Maxim Podberezhskiy
     */
    public function attributeLabels(): array
    {
        return [
            static::ATTR_PASSWORD           => 'Введите новый пароль',
            static::ATTR_PASSWORD_CONFIRM   => 'Повторите пароль'
        ];
    }
}