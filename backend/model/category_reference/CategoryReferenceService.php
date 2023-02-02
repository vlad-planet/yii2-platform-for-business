<?php

namespace backend\models\category_reference;

use common\models\db\CategoryReference;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\db\StaleObjectException;

/**
 * Сервис работы с формой 'Справочник категорий'
 *
 * Class DynamicPages
 * @package frontend\models\category_reference
 *
 * @author Vladislav Bashlykov
 */
class CategoryReferenceService
{
    /**
     * @var CategoryReference
     */
    private $model;

    /**
     * @var CategoryReferenceForm
     */
    private $form;

    /**
     * При инициализации класса
     *
     * @param CategoryReference $form
     *
     * @author Vladislav Bashlykov
     */
    public function __construct(CategoryReferenceForm $form)
    {
        $this->model = $form->_model ?? new CategoryReference;
        $this->form  = $form;
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
        $this->model->name = Html::encode($this->form->name);

        return $this->model->save();
    }

    /**
     * Список категорий для селекта
     *
     * @return array
     */
    public static function getListForSelect(): array
    {
        $cache = Yii::$app->cache;
        $key = 'category_reference_list';

        $list = $cache->get($key);

        if ($list === false) {
            $list = $cache->getOrSet($key, function () {
                return ArrayHelper::map(CategoryReference::find()->all(), CategoryReference::ATTR_ID, CategoryReference::ATTR_NAME);
            }, 3600);
        }

        return $list;
    }
}