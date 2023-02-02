<?php

namespace frontend\models\dynamic_pages;

use frontend\core\search\SearchItemInterface;

/**
 * Сущность 'Динамические страницы'
 *
 * Class DynamicPagesItem
 *
 * @package frontend\models\dynamic_pages
 *
 * @property string $title
 * @property string $text
 * @property string $alias
 * @property string $date_create
 *
 * @author Vladislav Bashlykov
 */
class DynamicPagesItem implements SearchItemInterface
{
	/**
	 * Название
	 * @var string
	 */
	public $title;

	/**
	 * Текст
	 * @var string
	 */
    public $text;

	/**
	 * Алиас
	 * @var string
	 */
    public $alias;

	/**
	 * Дата создания/публикации новости
	 * @var string
	 */
    public $date_create;

	/**
	 * Ссылка на деталный просмотр
	 * @var string
	 */
	public $detail_url;

	/**
	 * Количество комментариев
	 * @var int
	 */
	public $comments_count = 0;
}