<?php

namespace frontend\models\notifications;

use frontend\core\search\SearchItemInterface;

/**
 * Сущность 'Уведомления'
 *
 * Class NotificationsItem
 *
 * @package frontend\models\notifications
 *
 * @property string $id ID записи
 * @property string $user_id ID пользователя
 * @property string $date_create Дата и время создания записи
 * @property string|null $date_view Дата и время просмотра
 * @property string $text Текст
 *
 * @author Vladislav Bashlykov
 */
class NotificationsItem implements SearchItemInterface
{
	/**
	 * ID записи
	 * @var string
	 */
	public $id;

	/**
	 * ID пользователя
	 * @var string
	 */
    public $user_id;

	/**
	 * Дата и время создания записи
	 * @var string
	 */
    public $date_create;

	/**
	 * Дата и время просмотра
	 * @var string|null
	 */
    public $date_view;

    /**
     * Текст
     * @var string
     */
    public $text;
}