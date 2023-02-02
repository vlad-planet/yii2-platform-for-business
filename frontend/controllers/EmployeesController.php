<?php

namespace frontend\controllers;

use frontend\models\actives\ActiveSearch;
use frontend\models\employees\EmployeesSearch;
use frontend\models\employees\EmployeesForm;

use common\models\db\ActiveEmployees;
use common\yii\web\Controller;

use Yii;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\base\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;

/**
 * Контроллер для работы с 'Сотрудники актива'
 *
 * Class ActiveEmployeesController
 * @package backend\controllers
 *
 * @author Vladislav Bashlykov
 */
class EmployeesController extends Controller
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
        return $this->render(static::ACTION_INDEX, [
            'result' => (new EmployeesSearch())->search(null)
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
        $searchModel = new ActiveSearch();
        $searchModel->load(Yii::$app->request->post());

        $model = new EmployeesForm();

        if (true === Yii::$app->request->isPost) {

            $model->load(Yii::$app->request->post(), '');
            $result = false;
            if (true === $model->validate()) {
                $result = $model->save();
            }

            return $this->asJson([
                'result' => $result,
                'errors' => $model->getFirstErrors()
            ]);
        }

        return $this->render(static::ACTION_CREATE, [
            'model' => $model,
            'searchModel' => $searchModel,
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
        $model = new EmployeesForm($this->findModel($id));

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
     * @return ActiveEmployees
     * @throws NotFoundHttpException
     *
     * @author Vladislav Bashlykov
     */
    protected function findModel(string $id): ActiveEmployees
    {
        if (($model = ActiveEmployees::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}