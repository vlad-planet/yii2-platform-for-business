<?php

namespace backend\models\news_comments;

use common\models\db\News;
use common\models\db\Users;
use common\models\db\NewsComments;

use common\yii\validators\ExistValidator;
use common\yii\validators\IntegerValidator;
use common\yii\validators\NumberValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UniqueValidator;
use common\yii\validators\UuidValidator;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * Поиск 'Комментарии к новостям' для модели `common\models\db\NewsComments`.
 */
class NewsCommentsSearch extends NewsComments
{
    /** @var string */
    public $id;
    const ATTR_ID = 'id';

    /** @var string */
    public $news_id;
    const ATTR_NEWS_ID = 'news_id';

    /** @var string */
    public $user_id;
    const ATTR_USER_ID = 'user_id';

    /** @var string */
    public $parent_id;
    const ATTR_PARENT_ID = 'parent_id';

    /** @var string */
    public $date_create;
    const ATTR_DATE_CREATE = 'date_create';

    /** @var string */
    public $text;
    const ATTR_TEXT = 'text';

    /** @var int */
    public $active;
    const ATTR_ACTIVE = 'active';

    const ACTIVE_TRUE  = 1;
    const ACTIVE_FALSE = 0;

    /**
     * {@inheritdoc}
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function rules(): array
    {
        return [
            [static::ATTR_ID, UuidValidator::class],
            [static::ATTR_ID, UniqueValidator::class],

            [static::ATTR_NEWS_ID, UuidValidator::class],
            [
                static::ATTR_NEWS_ID,
                ExistValidator::class,
                ExistValidator::ATTR_TARGET_CLASS => News::class,
                ExistValidator::ATTR_TARGET_ATTRIBUTE => News::ATTR_ID
            ],

            [static::ATTR_USER_ID, UuidValidator::class],
            [
                static::ATTR_USER_ID,
                ExistValidator::class,
                ExistValidator::ATTR_TARGET_CLASS => Users::class,
                ExistValidator::ATTR_TARGET_ATTRIBUTE => Users::ATTR_ID
            ],

            [static::ATTR_PARENT_ID, UuidValidator::class],
            [
                static::ATTR_PARENT_ID,
                ExistValidator::class,
                ExistValidator::ATTR_TARGET_CLASS => NewsComments::class,
                ExistValidator::ATTR_TARGET_ATTRIBUTE => NewsComments::ATTR_ID
            ],

            [static::ATTR_DATE_CREATE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],

            [static::ATTR_TEXT, StringValidator::class],
            [static::ATTR_TEXT, TrimValidator::class],

            [
                static::ATTR_ACTIVE,
                IntegerValidator::class,
                NumberValidator::ATTR_MIN => static::ACTIVE_FALSE,
                NumberValidator::ATTR_MAX => static::ACTIVE_TRUE
            ]
        ];
    }

    /**
     * {@inheritdoc}
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * {@inheritdoc}
     *  @return string
     *
     * @author Vladislav Bashlykov
     */
    public function formName(): string
    {
        return '';
    }

    /**
     * Данные с примененным поисковым запросом
     *
     * @param array $params
     * @return ActiveDataProvider
     *
     * @author Vladislav Bashlykov
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = NewsComments::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (true === $this->validate()) {
            $query->andFilterWhere(['=', static::ATTR_ID, $this->id]);
            $query->andFilterWhere(['=', static::ATTR_NEWS_ID, $this->news_id]);
            $query->andFilterWhere(['=', static::ATTR_USER_ID, $this->user_id]);
            $query->andFilterWhere(['=', static::ATTR_PARENT_ID, $this->parent_id]);
            $query->andFilterWhere(['ilike', new Expression('CAST(' . static::ATTR_DATE_CREATE . ' AS text)'), $this->date_create]);
            $query->andFilterWhere(['ilike', static::ATTR_TEXT, $this->text]);
            $query->andFilterWhere(['=', static::ATTR_ACTIVE, $this->active]);
        }

        return $dataProvider;
    }

    /**
     * Получаем кол-во коментариев соотвествующие ID news
     *
     * @param string $id
     * @return integer
     *
     * @author Vladislav Bashlykov
     */
    public static function getCountByNewsID(string $id): int
    {
        $query = NewsComments::find()
            ->where(['=', NewsComments::ATTR_NEWS_ID, $id])
            ->isActive();

        return $query->count();
    }
}