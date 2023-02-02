<?php

namespace frontend\models\regions;

use common\models\db\Regions;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Сервис работы с Регионами
 *
 * Class Regions
 * @package frontend\models\regions
 *
 * @author Vladislav Bashlykov
 */
class RegionsService
{
    /**
     * Список регионов
     *
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public static function getListForSelect(): array
    {
        $cache = Yii::$app->cache;
        $key = 'regions_list';

        $list = $cache->get($key);

        if ($list === false) {
            $list = $cache->getOrSet($key, function () {
                return ArrayHelper::map(Regions::find()->all(), Regions::ATTR_ID, Regions::ATTR_NAME);
            }, 3600);
        }

        return $list;
    }
}