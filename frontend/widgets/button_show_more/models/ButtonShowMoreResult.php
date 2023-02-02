<?php

namespace frontend\widgets\button_show_more\models;

/**
 * Результат для вьюхи
 * Class ButtonShowMoreResult
 *
 * @author Vladislav Baslykov
 */
class ButtonShowMoreResult
{
	/**
	 * URL следующей страницы
	 * @var string
	 */
	public $url;

	/**
	 * Текст кнопки
	 * @var string
	 */
	public $label;

	/**
	 * Общее количество страниц
	 * @var int
	 */
	public $limit;

	/**
	 * Номер текущей страницы
	 * @var int
	 */
	public $page_number;

	/**
	 * Название ключа в query номера страницы
	 * @var string
	 */
	public $page_param_name;
}