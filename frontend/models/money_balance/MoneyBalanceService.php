<?php

namespace frontend\models\money_balance;

use Yii;

/**
 * Сервис работы с балансом пользователя
 */
class MoneyBalanceService
{
    /**
     * Возвращает целое значение количества денег на счету текущего пользователя
     *
     * @return string
     */
    public static function getUserBalance(): string
    {
        $user = Yii::$app->user->identity;
        $balance = $user->balance->value ?? 0;

        return Yii::$app->formatter->asInteger($balance);
    }
}