<?php

namespace frontend\modules\personal\models\money_balance_logs;

use frontend\core\search\SearchItemInterface;

/**
 * Сущность лога баланса пользователя
 */
class MoneyBalanceLogsItem implements SearchItemInterface
{
    /** @var string ID записи */
    public $id;

    /** @var string Дата и время создания записи в БД */
    public $date_create;

    /** @var string ID пользователя */
    public $user_id;

    /** @var float Значение баланса */
    public $value;

    /** @var float Знак и сумма операции */
    public $change;

    /** @var string Комментарий */
    public $comment;
}