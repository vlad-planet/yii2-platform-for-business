<?php

use frontend\controllers\AuthController;
use frontend\controllers\IndexController;

$uuidRegex = '[({]?(0x)?[0-9a-fA-F]{8}([-,]?(0x)?[0-9a-fA-F]{4}){2}((-?[0-9a-fA-F]{4}-?[0-9a-fA-F]{12})|(,\{0x[0-9a-fA-F]{2}(,0x[0-9a-fA-F]{2}){7}\}))[)}]?';

return [
	'/' 		  => IndexController::routeId(IndexController::ACTION_INDEX),

	'auth/login'  => AuthController::routeId(AuthController::ACTION_LOGIN),
	'auth/logout' => AuthController::routeId(AuthController::ACTION_LOGOUT),
	'auth/signup' => AuthController::routeId(AuthController::ACTION_SIGNUP),
	'auth/soc'    => AuthController::routeId(AuthController::ACTION_SOCIAL),
];
