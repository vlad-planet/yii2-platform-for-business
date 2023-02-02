<?php

namespace frontend\modules\personal\controllers;

use common\yii\web\Controller;

use frontend\modules\personal\models\personal\PersonalProfileForm;

use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Контролер профиля пользователя
 * Class ProfileController
 * @package frontend\modules\personal\controllers
 *
 * @author Maxim Podberezhskiy
 */
class ProfileController extends BaseController
{
    const ACTION_INDEX = 'index';

    /**
     * @inheritdoc
     * @return array
     *
     * @author Vladislav Bashlykov
     */
    public function behaviors(): array
    {
        return parent::behaviors();
    }

    /**
     * Основная страница профиля
     *
     * @return string|Response
     * @throws Exception
     *
     * @author Vladislav Bashlykov
     */
    public function actionIndex(): Response|string
    {
        $model   = new PersonalProfileForm();
        $message = null;

        if ($model->load(Yii::$app->request->post()) && true === $model->validate()) {
            $model->save();

            $message = PersonalProfileForm::MESSAGE_TRUE;
        }

        return $this->render(static::ACTION_INDEX,[
            'model'   => $model,
            'message' => $message,
        ]);
    }

    /**
     * Поиск модели пользователя
     * @return null
     * @throws NotFoundHttpException
     *
     * @author Maxim Podberezhskiy
     */
    protected function findModel()
    {
        /** TODO понять что искать) */
        if (($model = null) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}