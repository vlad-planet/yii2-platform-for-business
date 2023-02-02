<?php

namespace backend\models\category_reference;

use common\models\db\CategoryReference;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * Поисковая модель для [[\common\models\db\CategoryReference]].
 */
class CategoryReferenceSearch extends Model
{
    /** @var string */
    public $name;
    const ATTR_NAME = 'name';

    /** @var string */
    public $date_create;
    const ATTR_DATE_CREATE = 'date_create';

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
            [static::ATTR_NAME, TrimValidator::class],
            [static::ATTR_NAME, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

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
    public function search($params)
    {
        $query = CategoryReference::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (true === $this->validate()) {
            $query->andFilterWhere(['ilike', static::ATTR_NAME, $this->name]);
            $query->andFilterWhere(['ilike', new Expression('CAST(' . static::ATTR_DATE_CREATE . ' AS text)'), $this->date_create]);
        }

        return $dataProvider;
    }
}