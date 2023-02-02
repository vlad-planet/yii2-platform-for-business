<?php

namespace frontend\controllers;

use common\yii\web\Controller;

use frontend\models\auth\AuthForm;
use frontend\models\auth\SignupForm;
use frontend\models\auth\AuthService;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;

/**
 * Контроллер авторизации.
 *
 * @author Pavel Scherbich
 */
class AuthController extends Controller
{
	const ACTION_LOGIN  = 'login';
	const ACTION_LOGOUT = 'logout';
	const ACTION_SIGNUP = 'signup';
	const ACTION_SOCIAL = 'social';

	const LAYOUT_NAME = 'auth';

	/**
	 * {@inheritdoc}
	 *
	 * @author Pavel Scherbich
	 */
	public function behaviors(): array
	{
		return [
			[
				'class'   => VerbFilter::class,
				'actions' => [
					static::ACTION_LOGOUT => ['POST']
				]
			]
		];
	}

    /**
     * {@inheritdoc}
     *
     * @author Vladislav Bashlykov
     */
    public function actions(): array
    {
        return [
            static::ACTION_SOCIAL => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSocSuccess'],
            ],
        ];
    }

	/**
	 * Страница авторизации.
	 *
	 * @return string|Response
	 *
	 * @author Pavel Scherbich
	 */
	public function actionLogin()
	{
		$this->layout = static::LAYOUT_NAME;

		$form = new AuthForm();

		if (true === $form->load(Yii::$app->request->post()) && true === $form->login()) {
		}

		return $this->render(static::ACTION_LOGIN, [
			'model' => $form
		]);
	}

    /**
     * Страница регистрации
     *
     * @throws \yii\base\Exception
     *
     * @author Maxim Podberezhskiy
     */
    public function actionSignup()
    {
        $this->layout = static::LAYOUT_NAME;

        $form = new SignupForm();

        if (true === $form->load(Yii::$app->request->post()) && true === $form->save()) {
            return $this->redirect(Url::to(AuthController::getUrlRoute(AuthController::ACTION_LOGIN)));
        }

        return $this->render(static::ACTION_SIGNUP, [
            'model' => $form
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
		return $this->redirect(Url::to(AuthController::getUrlRoute(AuthController::ACTION_LOGIN)));
	}

    /**
     * Авторизация пользователей через Сторонние Сервисы
     * Данные от Соц. сервисов
     *
     * @author Vladislav Bashlykov
     */
    public function onAuthSocSuccess($client): void
    {
        $attributes = $client->getUserAttributes();
        $source = $client->getId();
        $source_id = $attributes['id'];

        AuthService::usingService($source, $source_id, $attributes);
    }
}