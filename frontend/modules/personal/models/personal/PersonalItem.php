<?php

namespace frontend\modules\personal\models\personal;

use yii\base\Model;
use yii\helpers\Html;

/**
 * Сущность данных пользователя
 * Class PersonalItem
 *
 * @package frontend\models\personal
 *
 * @property string $login
 * @property string $firstName
 * @property string $lastName
 * @property string $secondName
 * @property string $photo
 *
 * @property string $fullName
 */
class PersonalItem extends Model
{
    /**
     * Логин пользователя (почта)
     * @var string
     */
    public string $login;

    /**
     * Имя пользователя
     * @var string
     */
    public string $firstName;

    /**
     * Фамилия пользователя
     * @var string
     */
    public string $lastName;

    /**
     * Отчество пользователя
     * @var string
     */
    public string $secondName;

    /**
     * Путь к фото пользователя
     * @var string
     */
    public string $photo;

	/**
	 * Дата регистрации
	 * @var string
	 */
	public string $dateRegistration;

    /**
     * Возвращает "Имя Фамилию" пользователя
     * @return string
     */
    public function getFullName(): string
    {
        $result = $this->login;
        $name = [];

        if (null !== $this->firstName) {
            $name[] = $this->firstName;
        }

        if (null !== $this->lastName) {
            $name[] = $this->lastName;
        }

        if (!empty($name)) {
            $result = implode(' ', $name);
        }

        return Html::encode($result);
    }
}