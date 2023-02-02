<?php

namespace backend\controllers;

use backend\models\news\NewsService;

use common\yii\web\Controller;
use common\models\db\NewsComments;

use backend\models\news_comments\NewsCommentsForm;
use backend\models\news_comments\NewsCommentsSearch;

use Yii;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;

/**
 * Контроллер комментариев для новостей реализует действия CRUD
 *
 * @author Vladislav Bashlykov
 */
class NewsCommentsController extends Controller
{
    const ACTION_INDEX  = 'index';
    const ACTION_VIEW   = 'view';
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    /**
     * @inheritDoc
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::Class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Список Комментариев для новостей
     *
     * @return string
     *
     * @author Vladislav Bashlykov
     */
    public function actionIndex(): string
    {
        $searchModel = new NewsCommentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(static::ACTION_INDEX, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Обзор записи
     *
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     *
     * @author Vladislav Bashlykov
     */
    public function actionView(string $id): string
    {
        return $this->render(static::ACTION_VIEW, [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создание записи
     *
     * @return string|Response
     *
     * @author Vladislav Bashlykov
     */
    public function actionCreate(): string|Response
    {
        $model = new NewsCommentsForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([static::ACTION_INDEX]);
        }

        return $this->render(static::ACTION_CREATE, [
            'model' => $model,
        ]);
    }

    /**
     * Обновление записи
     *
     * @param string $id ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     *
     * @author Vladislav Bashlykov
     */
    public function actionUpdate(string $id): string|Response
    {
        $model = new NewsCommentsForm($this->findModel($id));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([static::ACTION_INDEX]);
        }

        return $this->render(static::ACTION_UPDATE, [
            'model' => $model,
        ]);
    }

    /**
     * Удаление записи
     *
     * @param string $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     *
     * @author Vladislav Bashlykov
     */
    public function actionDelete(string $id): Response
    {
        $model = $this->findModel($id);

        $model->delete();

        return $this->redirect([static::ACTION_INDEX]);
    }

    /**
     * Находит запись по ID.
     *
     * @param string $id ID
     * @return NewsComments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     *
     * @author Vladislav Bashlykov
     */
    protected function findModel(string $id): NewsComments
    {
        if (($model = NewsComments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}