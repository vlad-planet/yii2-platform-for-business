<?php

namespace frontend\models\notifications;

use common\models\db\Notifications;
use Yii;

/**
 * Сервис работы с Уведомлениями
 *
 * Class Notifications
 * @package frontend\models\notifications
 *
 * @author Vladislav Bashlykov
 */
class NotificationsService
{
    /**
     * Непрочитанные уведомление
     *
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public static function notRead(): array
    {
        return Notifications::find()
            ->where([Notifications::ATTR_USER_ID => Yii::$app->user->identity->id])
            ->andWhere([Notifications::ATTR_DATE_VIEW => null])
            ->all();
    }

    /**
     * Получаем кол-во непрочитанных уведомлений
     *
     * @return int
     *
     * @author Vladislav Bashlykov
     */
    public static function getCount(): int
    {
        return sizeof(static::notRead());
    }
}