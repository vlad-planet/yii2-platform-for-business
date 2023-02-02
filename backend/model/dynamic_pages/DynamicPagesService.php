<?php

namespace backend\models\dynamic_pages;

use common\models\db\DynamicPages;
use common\helpers\TranslitHelper;

use Yii;
use yii\helpers\Html;
use yii\db\StaleObjectException;

/**
 * Сервис работы с формой 'Динамические страницы'
 *
 * Class DynamicPages
 * @package frontend\models\dynamic_pages
 *
 * @author Vladislav Bashlykov
 */
class DynamicPagesService
{
	/**
	 * @var DynamicPages
	 */
	private $model;

	/**
	 * @var DynamicPagesForm
	 */
	private $form;

    /**
     * При инициализации класса
     *
     * @param DynamicPagesForm $form
     *
     * @author Vladislav Bashlykov
     */
	public function __construct(DynamicPagesForm $form)
	{
		$this->model = $form->_model ?? new DynamicPages;
		$this->form = $form;
	}

	/**
     * Сохранение данных в БД
     *
     * @return bool
     * @throws StaleObjectException
     *
     * @author Vladislav Bashlykov
     */
    public function save(): bool
    {
	    $this->model->title       = Html::encode($this->form->title);
	    $this->model->text        = $this->form->text;
	    $this->model->alias       = $this->getAlias();
	    $this->model->active      = $this->form->active;
	    $this->model->user_create = $this->getUserCreate();

        return $this->model->save();
    }

	/**
	 * Получение алиаса
	 *
	 * @return string
     *
	 * @author Vladislav Bashlykov
	 */
	private function getAlias(): string
	{
		return empty($this->form->alias) ? $this->generateAlias($this->form->title) : $this->generateAlias($this->form->alias);
	}

	/**
	 * Получение автора
	 *
	 * @return string
     *
	 * @author Vladislav Bashlykov
	 */
	private function getUserCreate(): string
	{
		$result = $this->model->user_create;

		/**
		 * user_create пишем, только для новой записи
		 */
		if (null === $result) {
			$result = Yii::$app->user->identity->id;
		}

		return $result;
	}

    /**
     * Генерация алиаса на основе заголовка
     *
     * @param string $title
     * @return string
     *
     * @author Vladislav Bashlykov
     */
    private function generateAlias(string $title): string
    {
	    return preg_replace('/[^- a-z\d]/', '', TranslitHelper::translit($title)) . '-' . time();
    }
}