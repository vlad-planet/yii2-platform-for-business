<?php

namespace backend\models\news;

use backend\models\news_comments\NewsCommentsSearch;

use common\models\db\News;
use common\models\db\Files;
use common\models\service\FileService;

use common\helpers\TranslitHelper;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * Сервис работы с формой Новостей
 *
 * Class NewsService
 * @package frontend\models\auth
 *
 * @author Maxim Podberezhskiy
 */
class NewsService
{
	/**
	 * @var News
	 */
	private $model;

	/**
	 * @var NewsForm
	 */
	private $form;

	public function __construct(NewsForm $form)
	{
		$this->model = $form->_model ?? new News;
		$this->form = $form;
	}

	/**
     * Сохранение в БД
     * @return bool
     *
     * @author Maxim Podberezhskiy
     */
    public function save(): bool
    {
	    $this->model->title       = Html::encode($this->form->title);
	    $this->model->text        = $this->form->text;
	    $this->model->alias       = $this->getAlias();
	    $this->model->active      = $this->form->active;
	    $this->model->user_create = $this->getUserCreate();
	    $this->model->image       = $this->getImage();

        return $this->model->save();
    }

	/**
	 * Получение фотки новости
	 *
	 * @return string|null
	 * @throws \yii\db\StaleObjectException
	 * @author Pavel Scherbich
	 */
	private function getImage(): ?string
	{
		$result = $this->form->image;

		/**
		 * Если из формы не пришёл файл и при этом, если он ранее был загружен, значит удаляем
		 */
		if (null !== $this->model->image && null !== $this->form->image) {
			($this->model->getFile()->one())->delete();
			$result = null;
		}

		/**
		 * Пробуем загрузить файл на сервак, если прилетел.
		 */
		$image = UploadedFile::getInstance($this->form, NewsForm::ATTR_FILE);

		if (null !== $image && false !== ($file = $this->saveImage($image))) {
			$result = $file->id;
		}

		return $result;
	}

	/**
	 * Получение алиаса
	 *
	 * @return string
	 * @author Pavel Scherbich
	 */
	private function getAlias(): string
	{
		return empty($this->form->alias) ? $this->generateAlias($this->form->title) : $this->form->alias;
	}

	/**
	 * Получение создателя новости
	 *
	 * @return string
	 * @author Pavel Scherbich
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
     * Сохранение картинки
     * @param UploadedFile $image
     *
     * @return bool|Files
     * @author Pavel Scherbich
     */
    private function saveImage(UploadedFile $image): ?Files
    {
        $file = new FileService();

        return $file->save($image);
    }

    /**
     * Генерация алиаса на основе заголовка новости
     * @param string $title
     * @return string
     *
     * @author Maxim Podberezhskiy
     */
    private function generateAlias(string $title): string
    {
	    return preg_replace('/[^- a-z\d]/', '', TranslitHelper::translit($title)) . '-' . time();
    }

    /**
     * Список новостей для селекта
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public static function getListForSelect(): array
    {
        $cache = Yii::$app->cache;
        $key = 'news_list';

        $list = $cache->get($key);

        if ($list === false) {
            $list = $cache->getOrSet($key, function () {
                return ArrayHelper::map(News::find()->all(), News::ATTR_ID, News::ATTR_TITLE);
            }, 3600);
        }

        return $list;
    }

    /**
     * Изменения значения поля $comments_count
     *
     * @param string $id
     * @return void
     *
     * @author Vladislav Bashlykov
     */
    static function alterCommentCount(string $id): void
    {
        if (($news = News::findOne($id)) !== null) {
            $news->comments_count = NewsCommentsSearch::getCountByNewsID($id);
            $news->updateAttributes([News::ATTR_COMMENTS_COUNT]);
        }
    }
}