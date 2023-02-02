<?php

namespace backend\controllers;

use backend\models\category_reference\CategoryReferenceForm;
use backend\models\category_reference\CategoryReferenceSearch;

use common\models\db\CategoryReference;
use common\yii\web\Controller;

use Yii;
use yii\web\Response;
use yii\base\Exception;
use yii\web\NotFoundHttpException;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;

/**
 * Контроллер для работы с 'Справочник категорий'
 *
 * Class CategoryReferenceController
 * @package backend\controllers
 *
 * @author Vladislav Bashlykov
 */
class CategoryReferenceController extends Controller
{
    const ACTION_INDEX  = 'index';
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    /**
     * Поведения/Примеси
     *
     * {@inheritdoc}
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
     * Индексная страница (список данных)
     *
     * @return string
     *
     * @author Vladislav Bashlykov
     */
    public function actionIndex(): string
    {
        $searchModel = new CategoryReferenceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(static::ACTION_INDEX, [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Создание записи
     *
     * @return string|Response
     * @throws Exception
     *
     * @author Vladislav Bashlykov
     */
    public function actionCreate(): Response|string
    {
        $model = new CategoryReferenceForm();

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
     * @param string $id
     * @return string|Response
     * @throws Exception
     *
     * @author Vladislav Bashlykov
     */
    public function actionUpdate(string $id): Response|string
    {
        $model = new CategoryReferenceForm($this->findModel($id));

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
        $this->findModel($id)->delete();

        return $this->redirect([static::ACTION_INDEX]);
    }

    /**
     * Формирования запроса модели по ID
     *
     * @param string $id
     * @return CategoryReference
     * @throws NotFoundHttpException
     *
     * @author Vladislav Bashlykov
     */
    protected function findModel(string $id): CategoryReference
    {
        if (($model = CategoryReference::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}