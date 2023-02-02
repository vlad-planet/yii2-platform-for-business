<?php

namespace backend\models\news_comments;

use common\models\db\News;
use common\models\db\Users;
use common\models\db\NewsComments;

use common\yii\validators\DefaultValueValidator;
use common\yii\validators\ExistValidator;
use common\yii\validators\IntegerValidator;
use common\yii\validators\NumberValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UuidValidator;

use yii\base\Model;

/**
 * Форма 'Коментарии к новостям'
 *
 * @author Vladislav Bashlykov
 */
class NewsCommentsForm extends Model
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
    public $text;
    const ATTR_TEXT = 'text';

    /** @var int */
    public $active;
    const ATTR_ACTIVE = 'active';

    /** @var NewsComments  */
    public $_model;

    const ACTIVE_TRUE  = 1;
    const ACTIVE_FALSE = 0;

    public function __construct(NewsComments $model = null, $config = [])
    {
        if (null !== $model) {
            $this->id        = $model->id;
            $this->news_id   = $model->news_id;
            $this->user_id   = $model->user_id;
            $this->parent_id = $model->parent_id;
            $this->text      = $model->text;
            $this->active    = $model->active;

            $this->_model = $model;
        }

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function rules(): array
    {
        return [
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
            [static::ATTR_PARENT_ID, DefaultValueValidator::class, DefaultValueValidator::ATTR_VALUE => NULL],

            [static::ATTR_TEXT, StringValidator::class],
            [static::ATTR_TEXT, TrimValidator::class],
            [static::ATTR_TEXT, RequiredValidator::class],

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
    public function attributeLabels(): array
    {
        return [
            static::ATTR_ID          => 'ID комментария',
            static::ATTR_NEWS_ID     => 'Новость',
            static::ATTR_USER_ID     => 'Пользователь ',
            static::ATTR_PARENT_ID   => 'Родительский комментарий',
            static::ATTR_TEXT        => 'Текст',
            static::ATTR_ACTIVE      => 'Активность'
        ];
    }

    /**
     * Сохранение формы в БД
     *
     * @return bool
     *
     * @author Vladislav Bashlykov
     */
    public function save(): bool
    {
        $result = false;

        if (true === $this->validate()) {
            $newsCommentsService = new NewsCommentsService($this);
            $result = $newsCommentsService->save();
        }
        return $result;
    }
}