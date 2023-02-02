<?php

namespace frontend\models\news_comments;

use common\models\db\NewsComments;

use Yii;
use yii\helpers\Html;

/**
 * Сервис работы с формой 'Комментарии к новостям'
 *
 * Class NewsCommentsService
 * @package frontend\models\news_comments
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
        $this->model->user_id   = Yii::$app->user->id;
        $this->model->parent_id = $this->form->parent_id;
        $this->model->text      = strip_tags($this->form->text);

        return $this->model->save();
    }
}