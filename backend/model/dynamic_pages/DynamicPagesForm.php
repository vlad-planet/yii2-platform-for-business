<?php

namespace backend\models\dynamic_pages;

use common\models\db\DynamicPages;
use common\models\queries\DynamicPagesQuery;
use common\yii\validators\IntegerValidator;
use common\yii\validators\NumberValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UniqueValidator;

use yii\base\Model;
use yii\db\StaleObjectException;

/**
 * Модель данных для формы 'Динамические страницы'
 *
 * @author Vladislav Bashlykov
 */
class DynamicPagesForm extends Model
{
    /** @var string */
    public $title;
    const ATTR_TITLE = 'title';

    /** @var string */
    public $text;
    const ATTR_TEXT = 'text';

    /** @var integer */
    public $active;
    const ATTR_ACTIVE = 'active';

    /** @var string */
    public $alias;
    const ATTR_ALIAS = 'alias';

    /** @var DynamicPages  */
    public $_model;

    /**
     * При инициализации класса
     *
     * @param DynamicPages|null $model
     * @param array $config
     *
     * @author Vladislav Bashlykov
     */
    public function __construct(DynamicPages $model = null, array $config = [])
    {
        if (null !== $model) {
            $this->title    = $model->title;
            $this->text     = $model->text;
            $this->alias    = $model->alias;
            $this->active   = $model->active;

            $this->_model = $model;
        }

        parent::__construct($config);
    }

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
            [static::ATTR_TITLE, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_TITLE, TrimValidator::class],
            [static::ATTR_TITLE, RequiredValidator::class],

            [static::ATTR_TEXT, StringValidator::class],
            [static::ATTR_TEXT, TrimValidator::class],
            [static::ATTR_TEXT, RequiredValidator::class],

            [
                static::ATTR_ACTIVE,
                IntegerValidator::class,
                NumberValidator::ATTR_MIN => DynamicPages::ACTIVE_FALSE,
                NumberValidator::ATTR_MAX => DynamicPages::ACTIVE_TRUE
            ],

            [static::ATTR_ALIAS, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_ALIAS, TrimValidator::class],
            [
                static::ATTR_ALIAS,
                UniqueValidator::class,
                UniqueValidator::ATTR_TARGET_CLASS => DynamicPages::class,
                UniqueValidator::ATTR_TARGET_ATTRIBUTE => DynamicPages::ATTR_ALIAS,
                UniqueValidator::ATTR_FILTER => function ($query) { /** @var $query DynamicPagesQuery */
                    if (null !== $this->_model) {
                        $query->andWhere(['!=', DynamicPages::ATTR_ALIAS, $this->_model->alias]);
                    }
                }
            ],
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
            static::ATTR_TITLE   => 'Заголовок',
            static::ATTR_TEXT    => 'Содержимое',
            static::ATTR_ACTIVE  => 'Активность',
            static::ATTR_ALIAS   => 'Алиас'
        ];
    }

    /**
     * Сохранение данных в БД
     *
     * @return bool
     * @throws StaleObjectException
     *
     * @author Vladislav Bashlykov
     */
    public function save(): bool
    {
        $result = false;

        if (true === $this->validate()) {
            $newsService = new DynamicPagesService($this);
            $result = $newsService->save();
        }

        return $result;
    }
}