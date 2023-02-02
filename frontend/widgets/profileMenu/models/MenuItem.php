<?php

namespace frontend\widgets\profileMenu\models;

/**
 * Модель представления пункта меню
 */
class MenuItem
{
	/** @var string - Название пункта меню */
	public $label;
    const PARAM_LABEL = 'label';

	/** @var string - Ссылка в меню */
	public $url;
    const PARAM_URL = 'url';

	/** @var bool - Активный или нет пункт меню */
	public $active = false;
    const PARAM_ACTIVE = 'active';

    public function __construct(string $label, string $url)
    {
        $this->label = $label;

        $this->url = $url;
    }
}