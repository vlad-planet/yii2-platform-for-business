<?php

namespace backend\controllers;

use backend\models\disqualified_persons\DisqualifiedPersonsForm;
use backend\models\disqualified_persons\DisqualifiedPersonsSearch;
use backend\models\disqualified_persons\ImportForm;
use backend\models\disqualified_persons\ImportService;

use common\models\db\DisqualifiedPersons;
use common\yii\web\Controller;

use Yii;
use yii\base\Exception;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * Контроллер для работы с 'Реестр дисквалифицированных лиц'
 *
 * Class DisqualifiedPersonsController
 * @package backend\controllers
 *
 * @author Vladislav Bashlykov
 */
class DisqualifiedPersonsController extends Controller
{
    const ACTION_INDEX  = 'index';
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';
    const ACTION_IMPORT = 'import';

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
                        static::ACTION_DELETE => ['POST'],
                        static::ACTION_IMPORT => ['POST'],
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
        $searchModel = new DisqualifiedPersonsSearch();
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
     *
     * @author Vladislav Bashlykov
     */
    public function actionCreate(): Response|string
    {
        $model = new DisqualifiedPersonsForm();

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
        $model = new DisqualifiedPersonsForm($this->findModel($id));

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
     * Импорт через эксельник
     * @return Response
     *
     * @author Maxim Podberezhskiy
     */
    public function actionImport(): Response
    {
        $importForm = new ImportForm();
        $importService = new ImportService;
        $importForm->fileToImport = UploadedFile::getInstance($importForm, ImportForm::ATTR_FILE_TO_IMPORT);

        if ($importForm->validate()) {
            $importService->import($importForm->fileToImport);
        }

        return $this->redirect([self::ACTION_INDEX]);
    }

    /**
     * Формирования запроса модели по ID
     *
     * @param string $id
     * @return DisqualifiedPersons
     * @throws NotFoundHttpException
     *
     * @author Vladislav Bashlykov
     */
    protected function findModel(string $id): DisqualifiedPersons
    {
        if (($model = DisqualifiedPersons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}