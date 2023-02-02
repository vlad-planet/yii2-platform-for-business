<?php

namespace backend\models\category_reference;

use common\models\db\CategoryReference;
use common\yii\validators\RequiredValidator;
use common\yii\validators\StringValidator;
use common\yii\validators\TrimValidator;

use yii\base\Model;
use yii\db\StaleObjectException;

/**
 * Модель данных для формы 'Справочник категорий'
 *
 * @author Vladislav Bashlykov
 */
class CategoryReferenceForm extends Model
{
    /** @var string */
    public $name;
    const ATTR_NAME = 'name';

    /** @var CategoryReference  */
    public $_model;

    /**
     * При инициализации класса
     *
     * @param CategoryReference|null $model
     * @param array $config
     *
     * @author Vladislav Bashlykov
     */
    public function __construct(CategoryReference $model = null, array $config = [])
    {
        if (null !== $model) {
            $this->name    = $model->name;
            $this->_model  = $model;
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
            [static::ATTR_NAME, StringValidator::class, StringValidator::ATTR_MAX => StringValidator::VARCHAR_LENGTH],
            [static::ATTR_NAME, TrimValidator::class],
            [static::ATTR_NAME, RequiredValidator::class],
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
            static::ATTR_NAME   => 'Наименование категории',
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
            $newsService = new CategoryReferenceService($this);
            $result = $newsService->save();
        }

        return $result;
    }
}