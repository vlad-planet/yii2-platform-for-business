<?php

namespace frontend\models\news_comments;

use frontend\core\search\SearchItemInterface;

/**
 * Сущность 'Комментарии к новостям'
 *
 * Class NewsCommentsItem
 *
 * @package frontend\models\news_comments
 *
 * @property string $id ID записи
 * @property string $news_id ID новости
 * @property string $user_id ID пользователя
 * @property string|null $parent_id ID родительского комментария
 * @property string $date_create Дата и время добавления
 * @property string $text Текст
 * @property int|null $active Активность
 *
 * @author Vladislav Bashlykov
 */
class NewsCommentsItem implements SearchItemInterface
{
	/**
	 * ID записи
	 * @var string
	 */
	public $id;

	/**
	 * ID новости
	 * @var string
	 */
    public $news_id;

    /**
     * ID пользователя
     * @var string
     */
    public $user_id;

    /**
     * ID родительского комментария
     * @var string|null
     */
    public $parent_id;

    /**
	 * Дата и время создания записи
	 * @var string
	 */
    public $date_create;

    /**
     * Текст
     * @var string
     */
    public $text;

    /**
     * Активность
     * @var int|null
     */
    public $active;

    /**
     * Автор Users
     * @var string
     */
    public $author;
}