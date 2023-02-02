<?php

namespace frontend\models\auth;

use common\models\db\Auth;
use common\models\db\Users;
use Yii;


/**
 * Авторизация пользователей через Сторонние Сервисы
 *
 * @author Vladislav Bashlykov
 */
class AuthService
{
    const ATTR_USER_ID   = 'user_id';
    const ATTR_SOURCE    = 'source';
    const ATTR_SOURCE_ID = 'source_id';

    /** @var object */
    static object $user;

    const ATTR_LOGIN    = 'login';
    const ATTR_PASSWORD = 'password';

    /**
     * Получение записи о сторонем сервисе
     *
     * @author Vladislav Bashlykov
     */
    static function getAuth($source, $source_id): bool
    {
        $auth = Auth::find()->where([
            static::ATTR_SOURCE    => $source,
            static::ATTR_SOURCE_ID => $source_id,
        ])->one();

        if($auth){  // *DRY
            self::$user = $auth->user;
            Yii::$app->user->login(self::$user);
            return true;
        }
        return false;
    }

    /**
     * Добавление в БД записи о сторонем сервисе
     *
     * @author Vladislav Bashlykov
     */
    static function addAuthData($user_id, $source, $source_id): bool
    {
        $auth = new Auth([
            static::ATTR_USER_ID   => $user_id,
            static::ATTR_SOURCE    => $source,
            static::ATTR_SOURCE_ID => $source_id,
        ]);

        if ($auth->save()) {  // *DRY
            self::$user = $auth->user;
            Yii::$app->user->login(self::$user);
            return true;
        } //else { print_r($auth->getErrors()); }
        return false;
    }

    /**
     * Получение записи о пользователе
     *
     * @author Vladislav Bashlykov
     */
    static function getUser($login): bool
    {
        $user = Users::find()->where([static::ATTR_LOGIN => $login]);

        if($user->exists()){
            self::$user = $user;
            return true;
        }
        return false;
    }

    /**
     * Добавдения пользователя в БД
     *
     * @author Vladislav Bashlykov
     */
    static function addUserData($login): bool
    {
        $password = Yii::$app->security->generateRandomString(8);

        $user = new Users([
            static::ATTR_LOGIN    => $login,
            static::ATTR_PASSWORD => $password,
        ]);
        $user->generateAuthKey();
        $user->setPassword($password);
        //$user->generatePasswordResetToken();

        if ($user->save()) {
            self::$user = $user;
            return true;
        } //else { print_r($user->getErrors()); }
        return false;
    }

    /**
     * Обработчик полученных данных от клиента стороннего сервиса
     *
     * @author Vladislav Bashlykov
     */
    static function usingService($source, $source_id, $attributes): void
    {
        if (Yii::$app->user->isGuest)                                               // если пользователь не аторизован
        {
            if (false === self::getAuth($source, $source_id)) {                     // Проверяем, есть ли, запись в БД, сторонего сервиса. если да, авторизуем пользователя

                $login = $attributes['email']; // $attributes['phone']              // иначе получаем логин: (емайл или телефон)

                if (true === self::getUser($login)) {                               // если запись о пользователе найдена в бд
                                                                                    // добавляем в бд запись сторонего сервиса, и привязываем к записи пользщователя по user_id, и авторизуем его
                    self::addAuthData(self::$user->id, $source, $source_id);

                } else {                                                            // если запись о пользователе не найдена в бд
                                                                                    // добавляем в бд запись о пользователе
                    if (true === self::addUserData($attributes['email'])) {
                                                                                    //  добавляем в бд запись сторонего сервиса, и привязываем к записи пользщователя
                        self::addAuthData(self::$user->id, $source, $source_id);
                    }

                }
            }
        }
    }
}