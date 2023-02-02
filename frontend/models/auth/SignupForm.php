<?php

namespace frontend\models\auth;

use common\models\db\Users;

use common\models\service\UserService;
use common\yii\validators\EmailValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UniqueValidator;

use yii\base\Model;

/**
 * Форма регистрации пользователя
 *
 * Class SignupForm
 * @package frontend\models\auth
 *
 * @author Maxim Podberezhskiy
 */
class SignupForm extends Model
{
    /** @var string */
    public $first_name;
    const ATTR_FIRST_NAME = 'first_name';

    /** @var string */
    public $second_name;
    const ATTR_SECOND_NAME = 'second_name';

    /** @var string */
    public $last_name;
    const ATTR_LAST_NAME = 'last_name';

    /** @var string */
    public $phone;
    const ATTR_PHONE = 'phone';

    /** @var string */
    public $login;
    const ATTR_LOGIN = 'login';

    /** @var string */
    public $password_first;
    const ATTR_PASSWORD_FIRST = 'password_first';

    /** @var string */
    public $password_second;
    const ATTR_PASSWORD_SECOND = 'password_second';

    /** @var string */
    public $inn;
    const ATTR_INN = 'inn';

    /** @var string */
    public $snils;
    const ATTR_SNILS = 'snils';

    public function formName()
    {
        return '';
    }

    /**
     * @return array[]
     *
     * @author Maxim Podberezhskiy
     */
    public function rules(): array
    {
        return [
            [static::ATTR_FIRST_NAME, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => 'Имя обязательно для заполнения'],
            [static::ATTR_FIRST_NAME, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_FIRST_NAME, TrimValidator::class],

            [static::ATTR_LAST_NAME, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => 'Фамилия обязательна для заполнения'],
            [static::ATTR_LAST_NAME, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_LAST_NAME, TrimValidator::class],

            [static::ATTR_SECOND_NAME, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_SECOND_NAME, TrimValidator::class],

            [static::ATTR_PHONE, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => 'Номер телефона обязателен для заполнения'],
            [static::ATTR_PHONE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_PHONE, TrimValidator::class],
            [
                static::ATTR_PHONE,
                'match',
                'pattern' => UserService::PHONE_PATTERN
            ],

            [static::ATTR_LOGIN, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => 'Адрес электронной почты обязателен для заполнения'],
            [static::ATTR_LOGIN, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_LOGIN, TrimValidator::class],
            [static::ATTR_LOGIN, EmailValidator::class],
            [
                static::ATTR_LOGIN,
                UniqueValidator::class,
                UniqueValidator::ATTR_TARGET_CLASS => Users::class,
                UniqueValidator::ATTR_MESSAGE => 'Почта занята'
            ],

            [static::ATTR_PASSWORD_FIRST, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => 'Пароль обязателен для заполнения'],
            [static::ATTR_PASSWORD_FIRST, TrimValidator::class],
            [
                static::ATTR_PASSWORD_FIRST,
                StringValidator::class,
                StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH,
                StringValidator::ATTR_MIN => StringValidator::VARCHAR_LENGTH_8
            ],

            [static::ATTR_PASSWORD_SECOND, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => 'Повтор пароля обязателен для заполнения'],
            [static::ATTR_PASSWORD_SECOND, TrimValidator::class],
            [
                static::ATTR_PASSWORD_SECOND,
                StringValidator::class,
                StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH,
                StringValidator::ATTR_MIN => StringValidator::VARCHAR_LENGTH_8
            ],
            [static::ATTR_PASSWORD_SECOND, 'checkPasswords'],

            [static::ATTR_SNILS, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH_20],
            [static::ATTR_SNILS, TrimValidator::class],

            [static::ATTR_INN, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH_20],
            [static::ATTR_INN, TrimValidator::class]

        ];
    }

    /**
     * Проверяем идентичность паролей
     *
     * @param string $attribute
     * @param $params
     *
     * @author Maxim Podberezhskiy
     */
    public function checkPasswords(string $attribute, $params): void
    {
        if (trim($this->password_first) !== trim($this->password_second)) {
            $this->addError($attribute, 'Введенные пароли не совпадают');
        }
    }

    /**
     * {@inheritdoc}
     *
     * @author Maxim Podberezhskiy
     */
    public function attributeLabels(): array
    {
        return [
            static::ATTR_LOGIN          => 'Логин',
            static::ATTR_FIRST_NAME     => 'Имя',
            static::ATTR_LAST_NAME      => 'Фамилия',
            static::ATTR_SECOND_NAME    => 'Отчество',
            static::ATTR_PHONE          => 'Номер телефона',
        ];
    }

    /**
     * Сохранение формы в БД
     *
     * @return bool
     * @throws \yii\base\Exception
     *
     * @author Maxim Podberezhskiy
     */
    public function save(): bool
    {
        $result = false;

        if (true === $this->validate()) {
            $signupService = new SignupService();
            $result = $signupService->save($this);
        }

        return $result;
    }
}