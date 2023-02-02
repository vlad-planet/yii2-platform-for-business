<?php

namespace frontend\modules\personal\models\personal;

use common\models\db\Users;
use common\models\service\PhotoService;

use Yii;

/**
 * Фабрика для создания PersonalItem
 */
class PersonalItemFactory
{
    /**
     * Создает PersonalItem текущего пользователя
     * @return PersonalItem
     */
    public static function createCurrenUserPersonalItem(): PersonalItem
    {
        $item = new PersonalItem();

        /** @var Users $user */
        $user = Yii::$app->user->identity;

	    $item->login            = $user->login;
	    $item->firstName        = $user->first_name;
	    $item->lastName         = $user->last_name;
	    $item->secondName       = $user->second_name;
	    $item->dateRegistration = Yii::$app->formatter->asDate($user->date_create, 'long');

        $item->photo = PhotoService::getCurrentUserPhotoPath();

        return $item;
    }
}