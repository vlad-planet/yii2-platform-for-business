<?php

namespace common\services\money_balance;

use common\models\db\MoneyBalance;

/**
 * Сервис для работы с балансом пользователей
 */
class MoneyBalanceService
{
    /**
     * Создает MoneyBalance для нового пользователя
     *
     * @param string $user_id
     * @return void
     */
    public static function balanceForNewUser(string $user_id): void
    {
        $balance = new MoneyBalance();

        $balance->user_id = $user_id;
        $balance->value   = MoneyBalance::BALANCE_DEFAULT;

        $balance->save();
    }
}