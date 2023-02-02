<?php

namespace frontend\controllers;

use frontend\models\passports_data\PassportsDataForm;

use common\models\db\PassportsData;
use common\yii\web\Controller;

use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Контроллер паспортных данных
 *
 * @author Vladislav Bashlykov
 */
class PassportsDataController extends Controller
{
    const ACTION_CREATE  = 'create';
    const ACTION_UPDATE  = 'update';

    /**
     * Создание записи
     *
     * @return string|Response
     *
     * @author Vladislav Bashlykov
     */
    public function actionCreate(): string|Response
    {
        $model = new PassportsDataForm();

        if ($model->load($this->request->post()) && $model->save()) {
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

        $model = new PassportsDataForm($this->findModel($id));

        if ($model->load($this->request->post()) && $model->save()) {
        }

        return $this->render(static::ACTION_UPDATE, [
            'model' => $model,
        ]);
    }

    /**
     * Находит модель PassportsData на основе ее значения первичного ключа
     *
     * @param string $id ID
     * @return PassportsData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     *
     * @author Vladislav Bashlykov
     */
    protected function findModel(string $id): PassportsData
    {
        if (($model = PassportsData::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}