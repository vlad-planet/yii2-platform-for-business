<?php

namespace frontend\models\news;

use frontend\core\search\SearchItemInterface;

/**
 * Сущность новости
 * Class NewsItem
 *
 * @package frontend\modules\news\model\news
 *
 * @property string $title
 * @property string $text
 * @property string $alias
 * @property string $date_create
 *
 * @author Maxim Podberezhskiy
 */
class NewsItem implements SearchItemInterface
{
    /**
     * ID новости
     * @var string
     */
    public $id;

	/**
	 * Название новости
	 * @var string
	 */
	public $title;

	/**
	 * Текст новости
	 * @var string
	 */
    public $text;

	/**
	 * Алиас новости
	 * @var string
	 */
    public $alias;

	/**
	 * Дата создания/публикации новости
	 * @var string
	 */
    public $date_create;

	/**
	 * Ссылка на деталку новости
	 * @var string
	 */
	public $detail_url;

	/**
	 * Количество комментариев к новости
	 * @var int
	 */
	public $comments_count = 0;

	/**
	 * Ссылка на изображение новости
	 * @var string
	 */
	public $image_url = '/assets/img/news01.png';

    /**
     * Ссылка на изображение предварительного просмотра новости
     * @var string
     */
    public $image_url_preview;
}