<?php

namespace frontend\modules\personal\models\money_balance_logs;

use common\models\db\MoneyBalanceLogs;
use frontend\core\search\SearchItemInterface;
use frontend\core\search\SearchResult;

use frontend\helpers\PriceHelper;
use Yii;
use yii\db\ActiveRecordInterface;

/**
 * Результат поиска логов баланса пользователя
 */
class MoneyBalanceLogsSearchResult extends SearchResult
{
    /** @var MoneyBalanceLogs[] */
    public $items;

    /**
     * Создаем модель
     *
     * @param MoneyBalanceLogs $model
     * @return SearchItemInterface
     */
    public function createModel(ActiveRecordInterface $model): SearchItemInterface
    {
        $result = new MoneyBalanceLogsItem();

        $result->id          = $model->id;
        $result->date_create = Yii::$app->formatter->asDate($model->date_create, 'php:d.m.Y');
        $result->user_id     = $model->user_id;
        $result->value       = Yii::$app->formatter->asInteger($model->value);
        $result->change      = Yii::$app->formatter->asInteger($model->change);
        $result->comment     = $model->comment;

        return $result;
    }
}