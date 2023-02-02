<?php

namespace common\models\service;

use common\models\db\Files;
use common\models\db\Users;

use Yii;
use yii\db\StaleObjectException;

/**
 * Сервис для работы с пользовательскими фото
 */
class PhotoService
{
    public const DEFAULT_AVATAR_PATH = 'assets/img/avatar.png';

    /**
     * Возвращает путь к фото текущего пользователя
     *
     * @return string
     */
    public static function getCurrentUserPhotoPath(): string
    {
        /** @var Users $user */
        $user = Yii::$app->getUser()->identity;

        return static::getUserPhotoPath($user);
    }

    /**
     * Возвращает путь к фото пользователя
     *
     * @param Users $user
     * @return string
     */
    public static function getUserPhotoPath(Users $user): string
    {
        $photoPath = static::DEFAULT_AVATAR_PATH;

        if (null !== $user->photo) {
            $photo = $user->photo;
            $photoPath = FileService::getPath($photo);
        }

        return $photoPath;
    }

    /**
     * Загружает фото пользователя
     *
     * @param $photo
     * @return void
     * @throws StaleObjectException
     */
    public static function uploadPhoto($photo): void
    {
        $file = static::savePhotoToFile($photo);

        /** @var Users $user */
        $user = Yii::$app->user->identity;

        if (null !== $user->photo) {
            $user->photo->delete();
        }
        $user->link(Users::RELATION_PHOTO, $file);
    }

    /**
     * Сохраняет фото в файл
     *
     * @param $photo
     * @return bool|Files
     */
    public static function savePhotoToFile($photo): bool|Files
    {
        return (new FileService())->save($photo);
    }
}