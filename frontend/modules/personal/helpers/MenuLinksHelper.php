<?php

namespace frontend\modules\personal\helpers;

use frontend\modules\personal\controllers\IndexController;
use frontend\modules\personal\controllers\DocumentsController;
use frontend\modules\personal\controllers\FinanceController;
use frontend\modules\personal\controllers\ActivesController;

use yii\helpers\Url;

/**
 * @author Pavel Scherbich
 */
class MenuLinksHelper
{
	/**
	 * Получение менюхи
	 *
	 * @return array
	 * @author Pavel Scherbich
	 */
	public static function getLinks(): array
	{
        return [
            [
                'title' => 'Главная',
                'link' => Url::to(IndexController::getUrlRoute(IndexController::ACTION_INDEX))
            ],
            [
                'title' => 'Реестр активов',
                'link' => Url::to(ActivesController::getUrlRoute(ActivesController::ACTION_LIST))
            ],
            [
                'title' => 'Финансы',
                'link' => Url::to(FinanceController::getUrlRoute(FinanceController::ACTION_INDEX))
            ],
        ];
	}
}