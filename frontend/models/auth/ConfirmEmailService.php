<?php

namespace frontend\models\auth;

use common\models\db\Users;
use common\services\email\MessageCreateService;
use common\services\email\MessageViewService;

use Yii;

class ConfirmEmailService
{
    /**
     * Отправка Email
     *
     * @param Users $user
     * @return bool
     *
     * @author Maxim Podberezhskiy
     */
    public static function sendEmail(Users $user): bool
    {
		$text = Yii::$app->view->render(MessageViewService::getPathToView(MessageViewService::VIEW_CONFIRM_EMAIL), ['user' => $user]);

		return (new MessageCreateService())->create($text, $user->login, 'Подтверждение электронного адреса');
    }
}