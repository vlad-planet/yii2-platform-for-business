<?php

namespace frontend\models\category_reference;

use common\models\db\CategoryReference;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Сервис работы со Справочником категорий
 *
 * Class CategoryReference
 * @package frontend\models\CategoryReference
 *
 * @author Vladislav Bashlykov
 */
class CategoryReferenceService
{
    /**
     * Список категорий
     *
     * @return array
     *
     * @author Vladislav Bashlykov
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