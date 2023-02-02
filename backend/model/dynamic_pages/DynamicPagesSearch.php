<?php

namespace backend\models\dynamic_pages;

use common\models\db\DynamicPages;
use common\yii\validators\IntegerValidator;
use common\yii\validators\NumberValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * Поисковая модель для [[\common\models\db\DynamicPages]].
 */
class DynamicPagesSearch extends Model
{
    /** @var string */
    public $text;
    const ATTR_TEXT = 'text';

    /** @var string */
    public $title;
    const ATTR_TITLE = 'title';

    /** @var integer */
    public $active;
    const ATTR_ACTIVE = 'active';

    /** @var string */
    public $date_create;
    const ATTR_DATE_CREATE = 'date_create';

    /** @var string */
    public $alias;
    const ATTR_ALIAS = 'alias';

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
            [static::ATTR_TITLE, TrimValidator::class],
            [static::ATTR_TITLE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_TEXT, TrimValidator::class],
            [static::ATTR_TEXT, StringValidator::class],

            [static::ATTR_ALIAS, TrimValidator::class],
            [static::ATTR_ALIAS, StringValidator::class],

            [static::ATTR_ACTIVE, IntegerValidator::class,
                NumberValidator::ATTR_MIN => DynamicPages::ACTIVE_FALSE,
                NumberValidator::ATTR_MAX => DynamicPages::ACTIVE_TRUE
            ],

            [static::ATTR_DATE_CREATE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
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
        $query = DynamicPages::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (true === $this->validate()) {
            $query->andFilterWhere(['ilike', static::ATTR_TITLE, $this->title]);
            $query->andFilterWhere(['ilike', static::ATTR_TEXT, $this->text]);
            $query->andFilterWhere(['ilike', static::ATTR_ALIAS, $this->alias]);
            $query->andFilterWhere(['ilike', new Expression('CAST(' . static::ATTR_DATE_CREATE . ' AS text)'), $this->date_create]);
            $query->andFilterWhere(['=', static::ATTR_ACTIVE, $this->active]);
        }

        return $dataProvider;
    }
}