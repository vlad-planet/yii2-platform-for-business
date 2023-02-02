<?php

namespace frontend\models\auth;

use common\models\db\Users;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;

use Yii;
use yii\base\Model;

/**
 * Форма авторизации
 *
 * @author Pavel Scherbich
 */
class AuthForm extends Model
{
	/** @var string */
	public $login;
	const ATTR_LOGIN = 'login';
	
	/** @var string */
	public $phone_number;
	const ATTR_PHONE_NUMBER = 'phone_number';	

	/** @var string */
	public $password;
	const ATTR_PASSWORD = 'password';

	/** @var boolean */
	public $rememberMe;
	const ATTR_REMEMBER_ME = 'rememberMe';

	/**
	 * @var Users|null
	 */
	private ?Users $_user = null;

	/**
	 * @return string
	 * @author Pavel Scherbich
	 */
	public function formName(): string
	{
		return '';
	}

	/**
	 * {@inheritdoc}
	 *
	 * @author Pavel Scherbich
	 */
	public function rules(): array
	{
		return [
			[static::ATTR_LOGIN, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => 'Логин обязателен для заполнения'],
			[static::ATTR_LOGIN, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

			[static::ATTR_PASSWORD, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => 'Пароль обязателен для заполнения'],
			[static::ATTR_PASSWORD, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
			[static::ATTR_PASSWORD, 'validatePassword']
		];
	}

	/**
	 * Валидация пароля
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 * @author Pavel Scherbich
	 */
	public function validatePassword(string $attribute, $params): void
	{
		$this->getUser();

		if ($this->_user === null || !Yii::$app->security->validatePassword($this->password, $this->_user?->password_hash)) {
			$this->addError($attribute, 'Не корректный логин/пароль');
		}
	}

	/**
	 * @author Pavel Scherbich
	 */
	protected function getUser(): void
	{
		$this->_user = Users::find()
			->andWhere([Users::ATTR_LOGIN => $this->login])
			//@todo вынести в сервис
			->orWhere([Users::ATTR_PHONE_NUMBER => preg_replace('/[^0-9]/', '', $this->login)])
			->one();
	}

	/**
	 * Logs in a user using the provided username and password.
	 *
	 * @return bool whether the user is logged in successfully
	 * @author Pavel Scherbich
	 */
	public function login(): bool
	{
		$result = false;

		if (true === $this->validate()) {
			if (null !== $this->_user) {
				$result = Yii::$app->user->login($this->_user, $this->rememberMe ? 360000 * 24 * 30 : 0);
			}
		}

		return $result;
	}
}