<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'personal' => [
            'class' => 'frontend\modules\personal\PersonalModule',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\db\Users',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'on afterLogin' => function($event) {
	            Yii::$app->user->identity->afterLogin($event);
            }
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
	        'showScriptName'      => false,
	        'enableStrictParsing' => true,
	        'rules' => require __DIR__ . '/routes.php'
        ],
        'i18n' => [
            'translations' => [
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                ],
            ],
        ],
		'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'esia' => [
                    'class' => 'heggi\yii2esia\Esia',
                    'clientId' => 'xxx',
                    'certPath' => __DIR__ . '/xxx.pem',
                    'privateKeyPath' => __DIR__ . '/xxx.key',
                    'privateKeyPassword' => 'xxx',
                    'scope' => 'fullname',
                    'production' => false,
                ],
                'odnoklassniki' => [
                    'class' => 'kotchuprik\authclient\Odnoklassniki',
                    'applicationKey' => 'odnoklassniki_app_public_key',
                    'clientId' => 'odnoklassniki_app_id',
                    'clientSecret' => 'odnoklassniki_client_secret',
                ],
                 'vkontakte' => [
                     'class' => 'yii\authclient\clients\VKontakte',
                     'clientId' => 'vkontakte_client_id',
                     'clientSecret' => 'vkontakte_client_secret',
                     'scope' => 'email'
                 ],
                /*
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => 'google_client_id',
                    'clientSecret' => 'google_client_secret',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => 'facebook_client_id',
                    'clientSecret' => 'секретный_ключ_facebook_client',
                ],
                */
            ],
        ]
    ],
    'params' => $params,
    'as beforeRequest' => [
	    'class' => 'yii\filters\AccessControl',
	    'rules' => [
		    [
			    'allow' => true,
			    'actions' => ['login', 'signup', 'social'],
		    ],
		    [
			    'allow' => true,
			    'roles' => ['@'],
		    ],
	    ],
	    'denyCallback' => function () {
		    return Yii::$app->response->redirect(['auth/login']);
	    },
    ],

];
