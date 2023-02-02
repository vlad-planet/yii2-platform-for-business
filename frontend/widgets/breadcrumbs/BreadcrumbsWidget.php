<?php

namespace frontend\widgets\breadcrumbs;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Виджет хлебных крошек
 */
class BreadcrumbsWidget extends Widget
{
    /**
     * @var array - Массив для рутового элемента
     */
    public $homeLink;

    /**
     * @var array - Массив для остальных ссылок
     */
    public $links = [];

    /**
     * @return string
     */
    public function run(): string
    {
        $this->setHomeLink();
        $this->setLinks();

        return $this->render('default', [
            'homeLink' => $this->homeLink,
            'links' => $this->links,
        ]);
    }

    /**
     * Собираем рутовую ссылку
     * @return LinkItem
     *
     * @author Maxim Podberezhskiy
     */
    private function setHomeLink()
    {
        $model = new LinkItem();

        $model->url = $this->homeLink['url'] ?? Yii::$app->homeUrl;
        $model->label = $this->homeLink['label'] ?? 'Главная';

        return $this->homeLink = $model;
    }

    /**
     * Собираем остальные ссылки
     * @return array
     *
     * @author Maxim Podberezhskiy
     */
    private function setLinks()
    {
        $result = [];
        if (!empty($this->links)) {
            foreach ($this->links as $link) {
                if (isset($link['url'])) {
                    $result[] = Html::a($link['label'], $link['url']);
                } else {
                    $result[] = Html::a($link, '');
                }
            }
        }

        return $this->links = $result;
    }
}