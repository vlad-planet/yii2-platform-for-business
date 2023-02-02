<?php

namespace frontend\controllers;

use common\yii\web\Controller;

use common\models\db\News;
use common\models\db\NewsComments;

use frontend\models\news\NewsSearch;
use frontend\models\news\NewsSearchView;

use frontend\models\news_comments\NewsCommentsForm;
use frontend\models\news_comments\NewsCommentsSearch;

use Yii;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class NewsController
 * @package frontend\modules\news\controllers
 *
 * @author Maxim Podberezhskiy
 */
class NewsController extends Controller
{
	const ACTION_INDEX           = 'index';
	const ACTION_VIEW            = 'view';
	const ACTION_COMMENTS        = 'comments';
	const ACTION_COMMENTS_CREATE = 'comments-create';

	const PARAM_ALIAS = 'alias';

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
	                static::ACTION_COMMENTS_CREATE => ['POST'],
                ],
            ],
            //Запрещаем смотреть в контроллер не авторизированным пользователям, кроме работы с куками
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    static::ACTION_COMMENTS_CREATE,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function () {
                    throw new ForbiddenHttpException();
                },
            ],
        ];
    }

	/**
	 * Список новостей
	 * @return string
	 * @author Pavel Scherbich
	 */
	public function actionIndex(): string
	{
        $newsComments = new NewsCommentsForm();

		return $this->render(static::ACTION_INDEX, [
			'result' => (new NewsSearch())->search(4)
		]);
	}

	/**
	 * Дедальный просмотр новости
	 * @var string $alias
	 * @return string
	 *
	 * @author Maxim Podberezhskiy
	 */
	public function actionView(string $alias): string
	{
		return $this->render(static::ACTION_VIEW, [
			'model' => new NewsSearchView($this->findModelByAlias($alias)),
		]);
	}

	/**
	 * @param string $alias
	 * @return News
	 * @throws NotFoundHttpException
	 *
	 * @author Maxim Podberezhskiy
	 */
	protected function findModelByAlias(string $alias): News
	{
		if (($model = News::findOne([News::ATTR_ALIAS => $alias])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	/**
	 * @param string $id
	 * @return News
	 * @throws NotFoundHttpException
	 *
	 * @author Maxim Podberezhskiy
	 */
	protected function findModel(string $id): News
	{
		if (($model = News::findOne([News::ATTR_ID => $id])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

    /**
     * Обзор коментариев соотвествующих ID новости
     *
     * @param string $id ID
     * @return string
     *
     * @author Vladislav Bashlykov
     */
    public function actionComments(string $id): string
    {
		$model = $this->findModel($id);

        return $this->renderPartial(static::ACTION_COMMENTS, [
            'result' => (new NewsCommentsSearch())->searchByNewsID($model->id)
        ]);
    }

    /**
     * Добавление комментария к новости
     *
     * @param string $id ID
     * @return object
     *
     * @author Vladislav Bashlykov
     */
    public function actionCommentsCreate(string $id): object
    {
	    $model = $this->findModel($id);

        $form  = new NewsCommentsForm();
	    $form->load(Yii::$app->request->post());
	    $form->news_id = $model->id;

        return $this->asJson([
            'result' => $form->save()
        ]);
    }
}