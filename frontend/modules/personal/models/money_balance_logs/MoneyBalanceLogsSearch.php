<?php

namespace frontend\modules\personal\models\money_balance_logs;

use common\models\db\MoneyBalanceLogs;
use common\yii\validators\FloatValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;

use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * Модель поиска логов баланса пользователя
 */
class MoneyBalanceLogsSearch extends Model
{
    const ATTR_USER_ID = 'user_id';

    /** @var string */
    public $date_create;
    const ATTR_DATE_CREATE = 'date_create';

    /** @var float Значение баланса */
    public $value;
    const ATTR_VALUE = 'value';

    /** @var float Изменение баланса */
    public $change;
    const ATTR_CHANGE = 'change';

    /** @var string Комментарий */
    public $comment;
    const ATTR_COMMENT = 'comment';

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [static::ATTR_DATE_CREATE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_VALUE, FloatValidator::class],

            [static::ATTR_CHANGE, FloatValidator::class],

            [static::ATTR_COMMENT, TrimValidator::class],
            [static::ATTR_COMMENT, StringValidator::class],
        ];
    }

    public function formName(): string
    {
        return '';
    }

    /**
     * @param int $limit
     * @return MoneyBalanceLogsSearchResult
     */
    public function search(int $limit = 20)
    {
        $query = MoneyBalanceLogs::find()->currentUser();

        if (true === $this->validate()) {
            $query->andFilterWhere(['=', static::ATTR_VALUE, $this->value]);
            $query->andFilterWhere(['ilike', new Expression('CAST(' . static::ATTR_DATE_CREATE . ' AS text)'), $this->date_create]);
            $query->andFilterWhere(['=', static::ATTR_CHANGE, $this->change]);
            $query->andFilterWhere(['ilike', static::ATTR_COMMENT, $this->comment]);
        }

        $query->orderBy([static::ATTR_DATE_CREATE => SORT_DESC]);

        return (new MoneyBalanceLogsSearchResult($query, $limit));
    }

    /**
     * Ищет среди депозитов
     *
     * @param int $limit
     * @return MoneyBalanceLogsSearchResult
     */
    public function searchDeposits(int $limit = 20): MoneyBalanceLogsSearchResult
    {
        $query = MoneyBalanceLogs::find()->currentUser()->deposits();

        $query->orderBy([static::ATTR_DATE_CREATE => SORT_DESC]);

        return (new MoneyBalanceLogsSearchResult($query, $limit));
    }

    /**
     * Ищет среди списаний
     *
     * @param int $limit
     * @return MoneyBalanceLogsSearchResult
     */
    public function searchWithdrawals(int $limit = 20): MoneyBalanceLogsSearchResult
    {
        $query = MoneyBalanceLogs::find()->currentUser()->withdrawals();

        $query->orderBy([static::ATTR_DATE_CREATE => SORT_DESC]);

        return (new MoneyBalanceLogsSearchResult($query, $limit));
    }
}