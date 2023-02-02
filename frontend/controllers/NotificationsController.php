<?php

namespace frontend\controllers;

use frontend\models\notifications\NotificationsSearch;

use common\models\db\Notifications;
use common\yii\web\Controller;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Контроллер для работы с 'Уведомления'
 *
 * Class NotificationsController
 * @package frontend\controllers
 *
 * @author Vladislav Bashlykov
 */
class NotificationsController extends Controller
{
    const ACTION_INDEX  = 'index';

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
            'result' => (new NotificationsSearch())->search()
        ]);
    }

    /**
     * Формирования запроса модели по ID
     *
     * @param string $id
     * @return Notifications
     * @throws NotFoundHttpException
     *
     * @author Vladislav Bashlykov
     */
    protected function findModel(string $id): Notifications
    {
        if (($model = Notifications::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}