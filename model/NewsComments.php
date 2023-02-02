<?php

namespace common\models\db;

use backend\models\news\NewsService;
use common\models\queries\NewsQuery;
use common\models\queries\UserQuery;
use common\models\queries\NewsCommentsQuery;

use common\yii\validators\DateValidator;
use common\yii\validators\ExistValidator;
use common\yii\validators\IntegerValidator;
use common\yii\validators\NumberValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UniqueValidator;
use common\yii\validators\UuidValidator;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * Класс модели для таблицы "news_comments". Комментарии для новостей
 *
 * @property string $id ID записи
 * @property string $news_id ID новости
 * @property string $user_id ID пользователя
 * @property string|null $parent_id ID родительского комментария
 * @property string $date_create Дата и время добавления
 * @property string $text Текст
 * @property int|null $active Активность
 *
 * @property News $news
 * @property Users $users
 * @property NewsComments $parent
 *
 * @author Vladislav Bashlykov
 */
class NewsComments extends ActiveRecord
{
    const TABLE_NAME = 'news_comments';

    const ATTR_ID          = 'id';
    const ATTR_NEWS_ID     = 'news_id';
    const ATTR_USER_ID     = 'user_id';
    const ATTR_PARENT_ID   = 'parent_id';
    const ATTR_DATE_CREATE = 'date_create';
    const ATTR_TEXT        = 'text';
    const ATTR_ACTIVE      = 'active';

    const ACTIVE_TRUE  = 1;
    const ACTIVE_FALSE = 0;

    const RELEATION_NEWS          = 'news';
    const RELEATION_USERS         = 'users';
    const RELEATION_NEWS_COMMENTS = 'news_comments';

    /**
     * {@inheritdoc}
     * @return string
     *
     * @author Vladislav Bashlykov
     */
    public static function tableName(): string
    {
        return static::TABLE_NAME;
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
            [static::ATTR_ID, UuidValidator::class],
            [static::ATTR_ID, UniqueValidator::class],

            [static::ATTR_NEWS_ID, UuidValidator::class],
            [static::ATTR_USER_ID, RequiredValidator::class],
            [
                static::ATTR_NEWS_ID,
                ExistValidator::class,
                ExistValidator::ATTR_TARGET_CLASS => News::class,
                ExistValidator::ATTR_TARGET_ATTRIBUTE => News::ATTR_ID
            ],

            [static::ATTR_USER_ID, UuidValidator::class],
            [static::ATTR_USER_ID, RequiredValidator::class],
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

            [
                static::ATTR_DATE_CREATE,
                DateValidator::class,
                DateValidator::ATTR_FORMAT => DateValidator::FORMAT_DATATIM
            ],

            [static::ATTR_TEXT, StringValidator::class],
            [static::ATTR_TEXT, RequiredValidator::class],
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
    public function attributeLabels(): array
    {
        return [
            static::ATTR_ID          => 'ID записи',
            static::ATTR_NEWS_ID     => 'Новость',
            static::ATTR_USER_ID     => 'Пользователь',
            static::ATTR_PARENT_ID   => 'Родительский комментарий',
            static::ATTR_DATE_CREATE => 'Дата и время добавления',
            static::ATTR_TEXT        => 'Текст',
            static::ATTR_ACTIVE      => 'Активность'
        ];
    }

    /**
     * При сохранение записи
     *
     * @author Vladislav Bashlykov
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        NewsService::alterCommentCount($this->news_id);
    }

    /**
     * При удалении записи
     *
     * @author Vladislav Bashlykov
     */
    public function afterDelete()
    {
        parent::afterDelete();
        NewsService::alterCommentCount($this->news_id);
    }

    /**
     * Получение списка статусов активности
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public static function getActiveStatusVariants(): array
    {
        return [
            static::ACTIVE_TRUE  => 'Активен',
            static::ACTIVE_FALSE => 'Не активен'
        ];
    }

    /**
     * Получение текстового статуса активности
     * @return string|null
     *
     * @author Vladislav Bashlykov
     */
    public function getActiveStatusVariantsLabel(): ?string
    {
        return (static::getActiveStatusVariants())[$this->active] ?? null;
    }

    /**
     * Получает запрос для [[News]].
     * @return ActiveQuery|NewsQuery
     *
     * @author Vladislav Bashlykov
     */
    public function getNews(): ActiveQuery|NewsQuery
    {
        return $this->hasOne(News::Class, [News::ATTR_ID => static::ATTR_NEWS_ID]);
    }

    /**
     * Получает запрос для [[Users]].
     * @return ActiveQuery|UserQuery
     *
     * @author Vladislav Bashlykov
     */
    public function getUsers(): ActiveQuery|UserQuery
    {
        return $this->hasOne(Users::Class, [Users::ATTR_ID => static::ATTR_USER_ID]);
    }

    /**
     * Получает запрос для [[NewsComments]].
     * @return ActiveQuery|NewsCommentsQuery
     *
     * @author Vladislav Bashlykov
     */
    public function getParent(): ActiveQuery|NewsCommentsQuery
    {
        return $this->hasOne(NewsComments::Class, [NewsComments::ATTR_ID => static::ATTR_PARENT_ID]);
    }

    /**
     * {@inheritdoc}
     * @return NewsCommentsQuery Активный запрос, используемый этим классом AR.
     *
     * @author Vladislav Bashlykov
     */
    public static function find(): NewsCommentsQuery
    {
        return new NewsCommentsQuery(get_called_class());
    }
}