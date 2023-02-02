<?php

namespace frontend\models\price;

use frontend\helpers\PriceHelper;

/**
 * Модель цены
 * @author Pavel Scherbich
 */
class PriceItem
{
	/**
	 * Не отформатированная цена в БД
	 * @var float
	 */
	public $price;

	/**
	 * Отформатированная цена
	 * @var string
	 */
	public $price_formated;

	public function __construct(float $price)
	{
		$this->price = $price;
		$this->price_formated = PriceHelper::getPriceFormated($price);
	}
}