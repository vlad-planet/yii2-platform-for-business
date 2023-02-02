<?php

namespace backend\models\money_balance_logs;

use common\models\db\MoneyBalanceLogs;
use common\yii\validators\FloatValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * Модель поиска для MoneyBalanceLogs
 */
class MoneyBalanceLogsSearch extends Model
{
    /** @var string */
    public $user_id;
    const ATTR_USER_ID = 'user_id';

    /** @var string */
    public $date_create;
    const ATTR_DATE_CREATE = 'date_create';

    /** @var float Значение баланса */
    public $value;
    const ATTR_VALUE = 'value';

    /** @var float Изменение */
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

            [static::ATTR_USER_ID, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_VALUE, FloatValidator::class],

            [static::ATTR_CHANGE, FloatValidator::class],

            [static::ATTR_COMMENT, TrimValidator::class],
            [static::ATTR_COMMENT, StringValidator::class],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    public function formName(): string
    {
        return '';
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = MoneyBalanceLogs::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (true === $this->validate()) {
            $query->andFilterWhere(['=', static::ATTR_VALUE, $this->value]);
            $query->andFilterWhere([static::ATTR_USER_ID => $this->user_id]);
            $query->andFilterWhere(['ilike', new Expression('CAST(' . static::ATTR_DATE_CREATE . ' AS text)'), $this->date_create]);
            $query->andFilterWhere(['=', static::ATTR_CHANGE, $this->change]);
            $query->andFilterWhere(['ilike', static::ATTR_COMMENT, $this->comment]);
        }

        return $dataProvider;
    }
}
