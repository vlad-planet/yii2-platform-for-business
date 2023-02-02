<?php

namespace common\services\money_balance_logs;

use backend\models\money_balance\MoneyBalanceForm;
use common\models\db\MoneyBalanceLogs;

/**
 * Сервис работы с логами баланса
 */
class MoneyBalanceLogsService
{
    /**
     * Заносим все изменения баланса в логи
     *
     * @param MoneyBalanceForm $form
     * @param float $old_value
     * @return void
     */
    public static function balanceUpdateLogs(MoneyBalanceForm $form, float $old_value = 0): void
    {
        $log = new MoneyBalanceLogs();

        $log->user_id = $form->user_id;
        $log->value   = $old_value + $form->value;
        $log->change  = $form->value;
        $log->comment = $form->comment;

        $log->save();
    }
}