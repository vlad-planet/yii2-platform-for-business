<?php

namespace common\services\pdf\models;

/**
 * Модель товара для счета
 */
class Goods
{
    /** @var string */
    public $name;

    /** @var int */
    public $quantity;

    /** @var float */
    public $price;

    /** @var float */
    public $sum;
}