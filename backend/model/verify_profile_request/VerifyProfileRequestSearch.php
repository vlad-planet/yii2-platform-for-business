<?php

namespace backend\models\verify_profile_request;

use common\models\db\Users;
use common\models\db\VerifyProfileRequest;

use common\yii\validators\IntegerValidator;
use common\yii\validators\NumberValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * Поисковая модель для [[\common\models\db\VerifyProfileRequestSearch]].
 *
 * @author Vladislav Bashlykov
 */
class VerifyProfileRequestSearch extends Model
{
    /** @var string $fio */
    public $fio;
    const ATTR_FIO = 'fio';

    /** @var string $login */
    public $login;
    const ATTR_LOGIN = 'login';

    /** @var string $phone_number */
    public $phone_number;
    const ATTR_PHONE_NUMBER = 'phone_number';

    /** @var string $date_create */
    public $date_create;
    const ATTR_DATE_CREATE = 'date_create';

    /** @var integer $status */
    public $status;
    const ATTR_STATUS = 'status';

    /**
     * Правила валидации данных
     *
     * {@inheritdoc}
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function rules(): array
    {
        return [
            [static::ATTR_FIO, TrimValidator::class],
            [static::ATTR_FIO, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_LOGIN, TrimValidator::class],
            [static::ATTR_LOGIN, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_PHONE_NUMBER, TrimValidator::class],
            [static::ATTR_PHONE_NUMBER, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_DATE_CREATE, TrimValidator::class],
            [static::ATTR_DATE_CREATE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_STATUS, IntegerValidator::class, NumberValidator::ATTR_MIN => VerifyProfileRequest::STATUS_VERIFICATION, NumberValidator::ATTR_MAX => VerifyProfileRequest::STATUS_REJECTED],
        ];
    }

    /**
     * Наименование атрибутов
     *
     * {@inheritdoc}
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function attributeLabels(): array
    {
        return [
            static::ATTR_FIO          => 'ФИО',
            static::ATTR_LOGIN        => 'E-mail',
            static::ATTR_PHONE_NUMBER => 'Номер телефона',
            static::ATTR_DATE_CREATE  => 'Дата создания заявки',
            static::ATTR_STATUS       => 'status'
        ];
    }

    /**
     * Сценарии
     *
     * {@inheritdoc}
     * @return array
     *
     * @author Vladislav Bashlykov
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
     * Поиск по фильтру
     *
     * @param array $params
     * @return ActiveDataProvider
     *
     * @author Vladislav Bashlykov
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = VerifyProfileRequest::find()
            ->joinWith(VerifyProfileRequest::RELATION_USERS);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (true === $this->validate()) {

            if (!empty($this->date_create)) {
                $this->date_create = Yii::$app->formatter->asDate($this->date_create, 'php:Y-m-d');
            }

            $query->andFilterWhere(['ilike', new Expression(
                'CONCAT_WS(\' \','
                . Users::TABLE_NAME . '.' . Users::ATTR_LAST_NAME . ','
                . Users::TABLE_NAME . '.' . Users::ATTR_FIRST_NAME . ','
                . Users::TABLE_NAME . '.' . Users::ATTR_SECOND_NAME
                . ')'
            ), $this->fio]);
            $query->andFilterWhere(['ilike', Users::TABLE_NAME . '.' . static::ATTR_LOGIN, $this->login]);
            $query->andFilterWhere(['ilike', Users::TABLE_NAME . '.' . static::ATTR_PHONE_NUMBER, $this->phone_number]);
            $query->andFilterWhere(['ilike', new Expression('CAST(' . VerifyProfileRequest::TABLE_NAME . '.' . static::ATTR_DATE_CREATE . ' AS text)'), $this->date_create]);
            $query->andFilterWhere(['=', VerifyProfileRequest::TABLE_NAME . '.' . static::ATTR_STATUS, $this->status]);
        }

        return $dataProvider;
    }
}