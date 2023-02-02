<?php

namespace frontend\models\auth;

use common\models\db\Users;

use Yii;

class PasswordResetService
{
    /**
     * Отправка Email
     * @param Users $user
     * @return bool
     *
     * @author Maxim Podberezhskiy
     */
    public static function sendEmail(Users $user): bool
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )->setCharset('utf-8')
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($user->login)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }


    /**
     * @param ResetPasswordForm $form
     * @param Users $user
     * @return bool
     *
     * @author Maxim Podberezhskiy
     */
    public static function resetPassword(Users $user, ResetPasswordForm $form): bool
    {
        $user->setPassword($form->password);
        $user->password_reset_token = null;

        return $user->save();
    }

    /**
     * @param Users $user
     *
     * @return bool
     * @author Maxim Podberezhskiy
     */
    public static function setResetToken(Users $user): bool
    {
        $result = false;

        if (false === Users::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->updateAttributes([Users::ATTR_PASSWORD_RESET_TOKEN => $user->generatePasswordResetToken()]);
            $result = true;
        }

        return $result;
    }
}