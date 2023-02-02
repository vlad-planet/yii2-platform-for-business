<?php

namespace frontend\modules\personal\models\personal;

use common\models\db\Files;
use common\models\db\VerifyProfileRequest;

use common\models\service\FileService;

use Yii;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * Сервис работы с формой 'Профиль персоны'
 *
 * Class PersonalProfileService
 * @package frontend\modules\personal\models\personal
 *
 * @author Vladislav Bashlykov
 */
class PersonalProfileService
{
    /** @var VerifyProfileRequest $form */
    public $form;

    /**
     * Сохранение данных в БД
     *
     * @param PersonalProfileForm $form
     * @return bool
     * @throws
     *
     * @author Vladislav Bashlykov
     */
    public function save(PersonalProfileForm $form): bool
    {
        $model = $form->_model ?? new VerifyProfileRequest();

        $model->user_id                                 = Yii::$app->user->identity->id;

        $model->passport_nationality                    = Html::encode($form->passport_nationality);
        $model->passport_number                         = Html::encode($form->passport_number);
        $model->passport_date_issue                     = Html::encode($form->passport_date_issue);
        $model->passport_office                         = Html::encode($form->passport_office);
        $model->passport_whom_issued                    = Html::encode($form->passport_whom_issued);
        $model->passport_birth_place                    = Html::encode($form->passport_birth_place);
        $model->passport_bday_place                     = Html::encode($form->passport_bday_place);
        $model->passport_file                           = $this->getFile($form, VerifyProfileRequest::ATTR_PASSPORT_FILE);
        $model->passport_resident_address               = Html::encode($form->passport_resident_address);
        $model->passport_fact_resident_address          = Html::encode($form->passport_fact_resident_address);

        $model->personal_data_inn                       = Html::encode($form->personal_data_inn);
        $model->personal_data_snils                     = Html::encode($form->personal_data_snils);
        $model->personal_data_driving_license           = Html::encode($form->personal_data_driving_license);
        $model->personal_data_additional_files          = $this->getFile($form, VerifyProfileRequest::ATTR_PERSONAL_DATA_ADDITIONAL_FILES);

        return $model->save();
    }

    /**
     * Получение файла
     *
     * @param string $attr
     * @return string|null
     *
     * @author Vladislav Bashlykov
     */
    private function getFile($form, string $attr): ?string
    {
        $result = '';
        /**
         * Пробуем загрузить файл на сервак, если прилетел.
         */
        $image = UploadedFile::getInstance($form, $attr);

        if (null !== $image && false !== ($file = $this->saveFile($image))) {
            $result = $file->id;
        }

        return $result;
    }

    /**
     * Сохранение картинки
     * @param UploadedFile $image
     *
     * @return bool|Files
     * @author Vladislav Bashlykov
     */
    private function saveFile(UploadedFile $image): ?Files
    {
        $file = new FileService();

        return $file->save($image);
    }
}