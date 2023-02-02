<?php

namespace backend\models\money_balance;

use common\models\db\MoneyBalance;

use common\services\money_balance_logs\MoneyBalanceLogsService;
use yii\web\NotFoundHttpException;

/**
 * Сервис взаимодействующий с балансом пользователей
 */
class MoneyBalanceService
{
    /**
     * Внесение денег на счет
     *
     * @param MoneyBalanceForm $form
     * @return void
     * @throws NotFoundHttpException
     */
    public function deposit(MoneyBalanceForm $form): void
    {
        $balance = MoneyBalance::findOne([MoneyBalance::ATTR_USER_ID => $form->user_id]);

        if (null === $balance) {
            throw new NotFoundHttpException('The requested model does not exist.');
        }

        $balance->value += $form->value;
        $balance->updateAttributes([MoneyBalance::ATTR_VALUE]);

        MoneyBalanceLogsService::balanceUpdateLogs($form, $balance->oldAttributes['value']);
    }

    /**
     * Списание денег со счета
     *
     * @param MoneyBalanceForm $form
     * @return void
     * @throws NotFoundHttpException
     */
    public function withdraw(MoneyBalanceForm $form): void
    {
        $balance = MoneyBalance::findOne([MoneyBalance::ATTR_USER_ID => $form->user_id]);

        if (null === $balance) {
            throw new NotFoundHttpException('The requested model does not exist.');
        }

        $balance->value -= $form->value;
        $balance->updateAttributes([MoneyBalance::ATTR_VALUE]);

        MoneyBalanceLogsService::balanceUpdateLogs($form, $balance->oldAttributes['value']);
    }
}