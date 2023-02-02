<?php

namespace frontend\modules\personal\controllers;

use common\models\service\PhotoService;

use frontend\modules\personal\models\actives_requests\ActivesRequestsSearch;
use frontend\models\actives\ActiveSearch;
use frontend\modules\personal\models\user_documents\UserDocumentSearch;
use frontend\modules\personal\models\personal\PhotoForm;
use frontend\modules\personal\models\personal\PersonalItemFactory;
use frontend\modules\personal\models\money_balance_logs\MoneyBalanceLogsSearch;

use Yii;
use yii\db\StaleObjectException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class PersonalController
 * @package frontend\modules\news\controllers
 *
 * @author Maxim Podberezhskiy
 */
class IndexController extends BaseController
{
    const ACTION_INDEX            = 'index';
    const ACTION_UPLOAD_PHOTO     = 'upload-photo';

    /**
     * {@inheritdoc}
     *
     * @author Maxim Podberezhskiy
     */
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
	        'verbs' => [
		        'class'   => VerbFilter::class,
		        'actions' => [
			        static::ACTION_UPLOAD_PHOTO => ['POST'],
		        ]
	        ]
        ]);
    }

    /**
     * Главная страница личного кабинета
     *
     * @return string
     * @author Maxim Podberezhskiy
     */
    public function actionIndex(): string
    {
        return $this->render(static::ACTION_INDEX,[
            'actives' => (new ActiveSearch([ActiveSearch::ATTR_USER_ID => Yii::$app->user->identity->id]))->search()?->items,
            'docs'    => (new UserDocumentSearch())->search()->items,
            'person'  => PersonalItemFactory::createCurrenUserPersonalItem(),
            'request' => (new ActivesRequestsSearch())->search()->items
        ]);
    }

    /**
     * Загрузка фото пользователя
     *
     * @return Response
     * @throws StaleObjectException
     */
    public function actionUploadPhoto(): Response
    {
        $photoForm = new PhotoForm();

        if ($photoForm->load(Yii::$app->request->post()) && true === $photoForm->validate()) {
            $photoForm->photo = UploadedFile::getInstance($photoForm, PhotoForm::ATTR_PHOTO);

            PhotoService::uploadPhoto($photoForm->photo);
        }

        return $this->redirect(Url::toRoute(static::getUrlRoute(static::ACTION_INDEX)));
    }
}