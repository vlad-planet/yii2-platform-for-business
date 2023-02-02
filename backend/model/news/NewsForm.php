<?php

namespace backend\models\news;

use common\models\db\Files;
use common\models\db\News;
use common\yii\validators\ExistValidator;
use common\yii\validators\IntegerValidator;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;
use common\yii\validators\UniqueValidator;
use common\yii\validators\FileValidator;

use common\yii\validators\UuidValidator;
use yii\base\Model;

/**
 * Форма Новостей
 *
 * @author Maxim Podberezhskiy
 */
class NewsForm extends Model
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

    /** @var News  */
    public $_model;

    /** @var array */
    public $file;
	const ATTR_FILE = 'file';

    /** @var string */
    public $image;
	const ATTR_IMAGE = 'image';

    public function __construct(News $model = null, $config = [])
    {
        if (null !== $model) {
            $this->title    = $model->title;
            $this->text     = $model->text;
            $this->alias    = $model->alias;
            $this->active   = $model->active;
            $this->image    = $model->image;

            $this->_model = $model;
        }

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     *
     * @author Maxim Podberezhskiy
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
                IntegerValidator::ATTR_MIN => News::ACTIVE_FALSE,
                IntegerValidator::ATTR_MAX => News::ACTIVE_TRUE
            ],

            [static::ATTR_ALIAS, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_ALIAS, TrimValidator::class],
            [
                static::ATTR_ALIAS,
                UniqueValidator::class,
                UniqueValidator::ATTR_TARGET_CLASS => News::class,
                UniqueValidator::ATTR_TARGET_ATTRIBUTE => News::ATTR_ALIAS,
                UniqueValidator::ATTR_FILTER => function ($query) {
                    /** @var $query NewsQuery */
                    if (null !== $this->_model) {
                        $query->andWhere(['!=', News::ATTR_ALIAS, $this->_model->alias]);
                    }
                }
            ],
            [static::ATTR_FILE, FileValidator::ATTR_TYPE_IMAGE,
                FileValidator::ATTR_EXTENSIONS                   => ['jpg', 'jpeg', 'png', 'gif'],
                FileValidator::ATTR_CHECK_EXTENSION_BY_MIME_TYPE => true,
                FileValidator::ATTR_MAX_SIZE                     => 512000, // 500 килобайт = 500 * 1024 байта = 512 000 байт
                FileValidator::ATTR_TOOBIG                       => 'Размер изображения не может превышать 500KB'
            ],

            [static::ATTR_IMAGE, UuidValidator::class],
            [
	            static::ATTR_IMAGE,
	            ExistValidator::class,
	            ExistValidator::ATTR_TARGET_CLASS => Files::class,
	            ExistValidator::ATTR_TARGET_ATTRIBUTE => Files::ATTR_ID
            ],
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @author Maxim Podberezhskiy
     */
    public function attributeLabels(): array
    {
        return [
            static::ATTR_TITLE   => 'Заголовок',
            static::ATTR_TEXT    => 'Содержимое',
            static::ATTR_ACTIVE  => 'Активность',
            static::ATTR_ALIAS   => 'Алиас',
            static::ATTR_FILE    => 'Изображение'
        ];
    }

    /**
     * Сохранение формы в БД
     *
     * @return bool
     *
     * @author Maxim Podberezhskiy
     */
    public function save(): bool
    {
        $result = false;

        if (true === $this->validate()) {
            $newsService = new NewsService($this);
            $result = $newsService->save();
        }

        return $result;
    }
}