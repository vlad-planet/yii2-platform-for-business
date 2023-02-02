<?php

namespace frontend\controllers;

use common\models\mutators\UserMutator;
use common\models\service\UserService;
use common\yii\web\Controller;

use frontend\models\auth\AuthForm;
use frontend\models\auth\PasswordResetService;
use frontend\models\auth\SignupForm;
use frontend\models\auth\PasswordResetRequestForm;
use frontend\models\auth\ResetPasswordForm;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * Контроллер авторизации.
 *
 * @author Pavel Scherbich
 */
class AuthController extends Controller
{
	const ACTION_LOGIN                  = 'login';
	const ACTION_LOGOUT                 = 'logout';
	const ACTION_SIGNUP                 = 'signup';
	const ACTION_REQUEST_PASSWORD_RESET = 'request-password-reset';
	const ACTION_RESET_PASSWORD         = 'reset-password';
	const ACTION_CONFIRM_EMAIL          = 'confirm-email';

	const PARAM_TOKEN = 'token';

	const LAYOUT_NAME = 'auth';

	/**
	 * {@inheritdoc}
	 *
	 * @author Pavel Scherbich
	 */
	public function behaviors(): array
	{
		return [
            'verbs' => [
				'class'   => VerbFilter::class,
				'actions' => [
					static::ACTION_LOGIN => ['POST'],
					static::ACTION_REQUEST_PASSWORD_RESET => ['POST'],
					static::ACTION_LOGOUT => ['POST']
				]
			],
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    static::ACTION_LOGIN,
                    static::ACTION_REQUEST_PASSWORD_RESET,
                    static::ACTION_SIGNUP,
                    static::ACTION_LOGOUT
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            static::ACTION_LOGIN,
                            static::ACTION_REQUEST_PASSWORD_RESET,
                            static::ACTION_SIGNUP
                        ],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [static::ACTION_LOGOUT],
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
	 * Страница авторизации.
	 *
	 * @return Response
	 *
	 * @author Pavel Scherbich
	 */
	public function actionLogin(): Response
    {
		$this->layout = static::LAYOUT_NAME;

		$form = new AuthForm();

	    $form->load(Yii::$app->request->post());
	    $result = $form->login();

		return $this->asJson([
			'result' => $result,
			'errors' => $form->getFirstErrors()
		]);
	}

    /**
     * Страница регистрации
     *
     * @throws \yii\base\Exception
     *
     * @author Maxim Podberezhskiy
     */
    public function actionSignup(): Response|string
    {
        $this->layout = static::LAYOUT_NAME;
        $form = new SignupForm();

        $form->load(Yii::$app->request->post());
        $result = $form->save();

        return $this->asJson([
            'result' => $result,
            'errors' => $form->getFirstErrors()
        ]);
    }

	/**
	 * @return Response
	 *
	 * @author Pavel Scherbich
	 */
	public function actionLogout(): Response
	{
		Yii::$app->user->logout(true);

		return $this->redirect(Url::to(IndexController::getUrlRoute(IndexController::ACTION_INDEX)));
	}

    /**
     * Страница запроса восстановления пароля
     * Requests password reset.
     *
     * @return Response
     */
    public function actionRequestPasswordReset(): Response
    {
        $this->layout = static::LAYOUT_NAME;

        $form = new PasswordResetRequestForm();
        $form->load(Yii::$app->request->post());

        $result = $form->sendRequest();

        return $this->asJson([
            'result' => $result,
            'errors' => $form->getFirstErrors()
        ]);
    }

    /**
     * Страница востоновления пароля
     *
     * @param string $token
     * @return mixed
     */
    public function actionResetPassword(string $token): mixed
    {
        $this->layout = static::LAYOUT_NAME;

        if (empty($token) || false === is_string($token)) {
            throw new ForbiddenHttpException('Password reset token cannot be blank.');
        }

        $user = UserService::getUserIfResetPasswordTokenValid($token);

        if (!$user) {
            throw new ForbiddenHttpException('Wrong password reset token.');
        }

        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && PasswordResetService::resetPassword($user, $model)) {
            Yii::$app->session->setFlash('success', 'New password was saved.');
            return $this->goHome();
        }

        return $this->render(static::ACTION_RESET_PASSWORD, [
            'model' => $model
        ]);
	}

    /**
     * Страница подтверждения email
     * @param string $token
     * @return string|Response
     * @throws ForbiddenHttpException
     *
     * @author Maxim Podberezhskiy
     */
    public function actionConfirmEmail(string $token)
    {
        $this->layout = static::LAYOUT_NAME;

        if (empty($token) || false === is_string($token)) {
            throw new ForbiddenHttpException('Confirm email token cannot be blank.');
        }

        $user = UserService::getUserByConfirmToken($token);

        if (!$user) {
            throw new ForbiddenHttpException('Wrong confirm email token.');
        }

        $result = false;
        if (true === UserMutator::confirmEmail($user)) {
            Yii::$app->user->login($user, 360000 * 24 * 30);
            $result = true;
        }

        return $this->render(static::ACTION_CONFIRM_EMAIL, ['result' => $result]);
    }
}