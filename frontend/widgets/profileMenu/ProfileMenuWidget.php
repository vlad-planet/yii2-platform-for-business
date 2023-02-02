<?php

namespace frontend\widgets\profileMenu;

use frontend\controllers\PersonalController;
use frontend\widgets\profileMenu\models\MenuItem;

use yii\base\Widget;
use yii\helpers\Url;
use Yii;

/**
 * Виджет меню личного кабинета
 */
class ProfileMenuWidget extends Widget
{
    /**
     * @var MenuItem[]
     */
    public array $items = [];

	/**
     * @var MenuItem[]
     */
    private array $menu_items = [];

	/**
	 * Текущий урл
	 * @var string
	 */
	private $currentUrl;

    /**
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->populateMenu();

		$this->setCurrentUrl();
        $this->setActive();
    }

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('menu', [
            'items' => $this->menu_items,
        ]);
    }

    /**
     * Наполняем меню пунктами
     *
     * @return void
     */
    private function populateMenu(): void
    {
		foreach ($this->items as $item) {
			$this->menu_items[] = new MenuItem($item['title'], $item['link']);
		}
    }

	private function setCurrentUrl()
	{
		$route    = Yii::$app->request->url;
		$routeExp = explode('?', $route);
		$this->currentUrl   = array_shift($routeExp);
	}

    /**
     * Определяем текущую активную вкладку
     *
     * @return void
     */
    private function setActive(): void
    {
        foreach ($this->menu_items as $item) {
            if ($item->url == $this->currentUrl) {
                $item->active = true;
            }
        }
    }
}