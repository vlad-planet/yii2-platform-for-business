<?php

namespace backend\models\news_comments;

use common\models\db\NewsComments;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Сервис работы с формой 'Комментарии к новостям'
 *
 * Class NewsCommentsService
 * @package backend\models\news-comments
 *
 * @author Vladislav Bashlykov
 */
class NewsCommentsService
{
    /**
     * @var NewsComments
     */
    private $model;

    /**
     * @var NewsCommentsForm
     *
     * @author Vladislav Bashlykov
     */
    private $form;

    public function __construct(NewsCommentsForm $form)
    {
        $this->model = $form->_model ?? new NewsComments;
        $this->form  = $form;
    }
    /**
     * @return bool
     *
     * @author Vladislav Bashlykov
     */
    public function save(): bool
    {
        $this->model->news_id   = $this->form->news_id;
        $this->model->user_id   = $this->form->user_id;
        $this->model->parent_id = $this->form->parent_id;
        $this->model->text      = strip_tags($this->form->text);
        $this->model->active    = $this->form->active;

        return $this->model->save();
    }

    /**
     * Список комментариев для селекта
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public static function getListForSelect(): array
    {
        $cache = Yii::$app->cache;
        $key = 'news_comments_list';

        $list = $cache->get($key);

        if ($list === false) {
            $list = $cache->getOrSet($key, function () {
                return ArrayHelper::map(NewsComments::find()->all(), NewsComments::ATTR_ID, NewsComments::ATTR_TEXT);
            }, 3600);
        }

        return $list;
    }
}