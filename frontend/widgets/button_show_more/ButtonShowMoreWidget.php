<?php

namespace frontend\widgets\button_show_more;

use frontend\widgets\button_show_more\models\ButtonShowMoreResult;

use yii\base\Widget;
use yii\data\Pagination;

/**
 * Виджет для кнопки "Показать ещё"
 *
 * @author Vladislav Baslykov
 */
class ButtonShowMoreWidget extends Widget
{
	/**
	 * URL для кнопки "Показать ещё"
	 * @var string
	 */
	public $url;

	/**
	 * Наименование кнопки
	 * @var string
	 */
	public $label = 'Показать ещё';

	/**
	 * @var Pagination
	 */
	public $pagination;

	/**
	 * @return string
	 * @author Vladislav Baslykov
	 */
	public function run(): string
	{
		return $this->render('default', [
			'result' => $this->createModel()
		]);
	}

	/**
	 * @return ButtonShowMoreResult
	 * @author Vladislav Baslykov
	 */
	private function createModel(): ButtonShowMoreResult
	{
		$model                  = new ButtonShowMoreResult;
		$model->url             = $this->getUrl();
		$model->limit           = $this->pagination->getPageCount();
		$model->label           = $this->label;
		$model->page_number     = ($this->pagination->page + 1);
		$model->page_param_name = $this->pagination->pageParam;

		return $model;
	}

	/**
	 * Получение урла для кнопки
	 * @return ?string
	 * @author Vladislav Baslykov
	 */
	private function getUrl(): ?string
	{
		$links = $this->pagination->getLinks();
		return $links['next'] ?? null;
	}
}