<?php

namespace frontend\widgets\pagination;
use yii\widgets\LinkPager;

/**
 * Пагинация - постраничная навигация
 *
 * @author Vladislav Bashlukov
*/
class Paginator extends LinkPager
{
    public $linkOptions = ['class' => 'pag_item'];
    public $pageCssClass = 'list__paginations_item';
    public $options = ['class' => 'list__paginations_list'];
    public $prevPageCssClass = 'list__paginations_item nav';
    public $nextPageCssClass = 'list__paginations_item nav';
    public $prevPageLabel = '<i class="i i-chevron-left-solid"></i>';
    public $nextPageLabel = '<i class="i i-chevron-right-solid"></i>';
}