<?php

namespace frontend\models\auth;

use common\models\db\PersonalData;
use common\models\db\Users;
use common\models\service\UserService;
use common\services\email\MessageCreateService;
use common\services\email\MessageViewService;

use Yii;
use yii\helpers\Html;

/**
 * Сервис работы с формой регистрации
 *
 * Class SignupService
 * @package frontend\models\auth
 *
 * @author Maxim Podberezhskiy
 */
class SignupService
{
    /**
     * @param SignupForm $form
     * @return bool
     * @throws \yii\base\Exception
     *
     * @author Maxim Podberezhskiy
     */
    public function save(SignupForm $form): bool
    {
		$modelUser = new Users();
		
        $transaction = Yii::$app->db->beginTransaction();
        $result = true;

	    $modelUser->first_name    = Html::encode($form->first_name);
	    $modelUser->second_name   = Html::encode($form->second_name);
	    $modelUser->last_name     = Html::encode($form->last_name);
	    $modelUser->login         = Html::encode($form->login);
	    $modelUser->phone_number  = UserService::trimPhoneNumber($form->phone);
	    $modelUser->password_hash = Yii::$app->security->generatePasswordHash($form->password_first);
	    $modelUser->confirm_token = Yii::$app->security->generateRandomString() . '_' . time();

	    if (false === $modelUser->save()) {
	        $transaction->rollBack();
			$result = false;
        }

	    if (!empty($form->inn) || !empty($form->snils)) {
			$modelPersonalData = new PersonalData();
            $modelPersonalData->user_id  = $modelUser->id;
            $modelPersonalData->inn      = Html::encode($form->inn);
            $modelPersonalData->snils    = Html::encode($form->snils);

            if (false === $modelPersonalData->save()) {
                $transaction->rollBack();
	            $result = false;
            }
        }
		if (true === $result) {
			$transaction->commit();
            MessageCreateService::create(
                Yii::$app->view->render(
                    MessageViewService::getPathToView(MessageViewService::VIEW_CONFIRM_EMAIL),
                    ['user' => $modelUser]
                ),
                $modelUser->login,
                'Подтверждение электронной почты'
            );
		}

        return $result;
    }
}