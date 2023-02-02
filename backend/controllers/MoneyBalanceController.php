<?php

namespace backend\controllers;

use backend\models\money_balance\MoneyBalanceForm;
use backend\models\money_balance\MoneyBalanceService;
use common\models\db\Users;
use common\yii\web\Controller;

use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Контроллер для работы с балансом пользователей
 */
class MoneyBalanceController extends Controller
{
    public const ACTION_DEPOSIT  = 'deposit';
    public const ACTION_WITHDRAW = 'withdraw';

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    static::ACTION_DEPOSIT  => ['POST'],
                    static::ACTION_WITHDRAW => ['POST'],
                ],
            ]
        ];
    }

    /**
     * Внесение денег на счет
     *
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionDeposit(string $id): Response|string
    {
        $model = new MoneyBalanceForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $service = new MoneyBalanceService();
            $service->deposit($model);
            return $this->redirect(UserController::getUrlRoute(UserController::ACTION_VIEW, [Users::ATTR_ID => $id]));
        }

        return $this->render(static::ACTION_DEPOSIT, [
            'model' => $model,
        ]);
    }

    /**
     * Списание денег со счета
     *
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionWithdraw(string $id): Response|string
    {
        $model = new MoneyBalanceForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $service = new MoneyBalanceService();
            $service->withdraw($model);
            return $this->redirect(UserController::getUrlRoute(UserController::ACTION_VIEW, [Users::ATTR_ID => $id]));
        }

        return $this->render(static::ACTION_WITHDRAW, [
            'model' => $model,
        ]);
    }
}