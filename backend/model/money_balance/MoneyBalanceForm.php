<?php

namespace backend\models\money_balance;

use common\models\db\Users;
use common\yii\validators\ExistValidator;
use common\yii\validators\FloatValidator;
use common\yii\validators\NumberValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UuidValidator;

use yii\base\Model;

/**
 * Форма изменения баланса
 */
class MoneyBalanceForm extends Model
{
    /* @var string */
    public $user_id;
    public const ATTR_USER_ID = 'user_id';

    /* @var float Значение изменения! Не значение баланса!!! */
    public $value;
    public const ATTR_VALUE = 'value';

    /** @var string Комментарий */
    public $comment;
    const ATTR_COMMENT = 'comment';

    const VALUE_MIN = 0.01;

    const SCENARIO_DEPOSIT = 'deposit';
    const SCENARIO_WITHDRAW = 'withdraw';

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [static::ATTR_USER_ID, RequiredValidator::class],
            [static::ATTR_USER_ID, UuidValidator::class],
            [
                static::ATTR_USER_ID,
                ExistValidator::class,
                ExistValidator::ATTR_TARGET_CLASS => Users::class,
                ExistValidator::ATTR_TARGET_ATTRIBUTE => Users::ATTR_ID
            ],

            [static::ATTR_VALUE, RequiredValidator::class],
            [static::ATTR_VALUE, FloatValidator::class, NumberValidator::ATTR_MIN => static::VALUE_MIN],
            [static::ATTR_VALUE, 'validateWithdrawalValue', 'on' => static::SCENARIO_WITHDRAW],

            [static::ATTR_COMMENT, TrimValidator::class],
            [static::ATTR_COMMENT, StringValidator::class],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            static::ATTR_USER_ID => 'Пользователь',
            static::ATTR_VALUE   => 'Значение',
            static::ATTR_COMMENT => 'Комментарий',
        ];
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_DEPOSIT] = [static::ATTR_USER_ID, static::ATTR_VALUE, static::ATTR_COMMENT];
        $scenarios[static::SCENARIO_WITHDRAW] = [static::ATTR_USER_ID, static::ATTR_VALUE, static::ATTR_COMMENT];
        return $scenarios;
    }

    /**
     * Проверка доступности необходимых средств на балансе при списании
     *
     * @param $attribute
     * @param $params
     * @return void
     */
    public function validateWithdrawalValue($attribute, $params): void
    {
        $user = Users::findOne($this->user_id);

        //Если списываемая сумма превышает баланс пользователя
        if ((null !== $user) && $this->value > $user->balance->value) {
            $this->addError($attribute, 'У пользователя недостаточно средств');
        }
    }
}