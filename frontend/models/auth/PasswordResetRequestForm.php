<?php

namespace frontend\models\auth;

use common\models\db\Users;
use common\yii\validators\EmailValidator;
use common\yii\validators\ExistValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\TrimValidator;

use Yii;
use yii\base\Model;

/**
 * Форма сброса пароля
 *
 * Class PasswordResetForm
 * @package frontend\modules\auth
 *
 * @author Maxim Podberezhskiy
 */
class PasswordResetRequestForm extends Model
{
	/**
	 * @var string
	 */
    public $login;
    const ATTR_LOGIN = 'login';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [static::ATTR_LOGIN, TrimValidator::class],
            [static::ATTR_LOGIN, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => 'Адрес электронной почты не заполнен'],
            [static::ATTR_LOGIN, EmailValidator::class],
            [
                static::ATTR_LOGIN,
                ExistValidator::class,
                ExistValidator::ATTR_TARGET_CLASS => Users::class,
                ExistValidator::ATTR_FILTER => [
                    Users::ATTR_STATUS => [
                        Users::STATUS_NEW,
                        Users::STATUS_CONFIRMED
                    ]
                ],
                ExistValidator::ATTR_MESSAGE => 'Пользователя с таким email нет'
            ],
        ];
    }

    /**
     * @return string
     * @author Maxim Podberezhskiy
     */
    public function formName(): string
    {
        return '';
    }

	/**
	 * @return string[]
	 * @author Pavel Scherbich
	 */
    public function attributeLabels(): array
    {
        return [
            static::ATTR_LOGIN => 'Email'
        ];
    }

    /**
     * @return bool
     *
     * @author Maxim Podberezhskiy
     */
    public function sendRequest(): bool
    {
        $result = false;

        if ($this->validate()) {

            $user = Users::find()
                ->filterByLogin($this->login)
                ->one();

            $result = (true === PasswordResetService::setResetToken($user) && true === PasswordResetService::sendEmail($user));
        }

        return $result;
    }
}