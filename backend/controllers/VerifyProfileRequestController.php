<?php

namespace backend\controllers;

use backend\models\verify_profile_request\VerifyProfileRequestSearch;

use common\models\db\VerifyProfileRequest;
use common\yii\web\Controller;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * Контроллер для работы с 'Запрос на внесение персональных данных'
 *
 * Class VerifyProfileRequestController
 * @package backend\controllers
 *
 * @author Vladislav Bashlykov
 */
class VerifyProfileRequestController extends Controller
{
    const ACTION_INDEX  = 'index';
    const ACTION_VIEW   = 'view';
    /**
     * Индексная страница (список данных)
     *
     * @return string
     *
     * @author Vladislav Bashlykov
     */
    public function actionIndex(): string
    {
        $searchModel = new VerifyProfileRequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(static::ACTION_INDEX, [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Страница детального просмотра
     *
     * @param string $id
     * @return string
     * @throws
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
     * Формирования запроса модели по ID
     *
     * @param string $id
     * @return VerifyProfileRequest
     * @throws NotFoundHttpException
     *
     * @author Vladislav Bashlykov
     */
    protected function findModel(string $id): VerifyProfileRequest
    {
        if (($model = VerifyProfileRequest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}