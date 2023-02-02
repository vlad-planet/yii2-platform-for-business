<?php

use frontend\modules\personal\models\personal\PersonalProfileForm;
use yii\helpers\Html;

/** @var $model PersonalProfileForm */
?>

<?= Html::beginForm('', 'POST', [
    'enableAjaxValidation' => true,
    'class' => 'addproduct__form js--profile_form',
    'enctype' => 'multipart/form-data'
]); ?>

<div class="lines-addproduct">
    <div class="line-addproduct kp-row">
        <div class="kp-col-4">
            <div class="box-text-titles"><span><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PASSPORT_NATIONALITY); ?>:</span><span class="req">*</span>
            </div>
        </div>
        <div class="kp-col-8">
            <div class="groupmaterial select">
                <div class="icon-select"></div>
                <?php
                $items   = ['1'=>'Российская федерация', '2'=>'США'];
                $options = ['prompt' => 'Выберите из списка...'];
                echo Html::dropDownList(PersonalProfileForm::ATTR_PASSPORT_NATIONALITY, $model->passport_nationality, $items, $options); ?>
            </div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-12 line">
            <div class="this-line">Паспорт</div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4">
            <div class="box-text-titles"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PASSPORT_NUMBER); ?>:</div>
        </div>
        <div class="kp-col-8">
            <div class="groupmaterial text">
                <?= Html::input('text', PersonalProfileForm::ATTR_PASSPORT_NUMBER, $model->passport_number, [
                    'class' => "n addproduct js-input-passport",
                    'placeholder' => "XX XX 000000",
                    'id' => "pasport"
                ]) ?>
            </div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4">
            <div class="box-text-titles"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PASSPORT_DATE_ISSUE); ?>:</div>
        </div>
        <div class="kp-col-8 kp-row">
            <div class="kp-col-4">
                <div class="groupmaterial text">
                    <?= Html::input('date', PersonalProfileForm::ATTR_PASSPORT_DATE_ISSUE, $model->passport_date_issue, [
                        'class' => "n addproduct",
                        'placeholder' => "01.01.2007",
                    ]) ?>
                </div>
            </div>
            <div class="kp-col-4">
                <div class="box-text-titles"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PASSPORT_OFFICE); ?>:</div>
            </div>
            <div class="kp-col-4">
                <div class="groupmaterial text">
                    <?= Html::input('text', PersonalProfileForm::ATTR_PASSPORT_OFFICE, $model->passport_office, [
                        'class' => "n addproduct js-input-passport-office",
                        'placeholder' => "000-000",
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4">
            <div class="box-text-titles"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PASSPORT_WHOM_ISSUED); ?>:</div>
        </div>
        <div class="kp-col-8">
            <div class="groupmaterial text">
                <?= Html::input('text', PersonalProfileForm::ATTR_PASSPORT_WHOM_ISSUED, $model->passport_whom_issued, [
                    'class' => "addproduct",
                ]) ?>
            </div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4">
            <div class="box-text-titles"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PASSPORT_BIRTH_PLACE); ?>:</div>
        </div>
        <div class="kp-col-8">
            <div class="groupmaterial text">
                <?= Html::input('text', PersonalProfileForm::ATTR_PASSPORT_BIRTH_PLACE, $model->passport_birth_place, [
                    'class' => "addproduct",
                ]) ?>
            </div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4">
            <div class="box-text-titles"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PASSPORT_BDAY_PLACE); ?></div>
        </div>
        <div class="kp-col-8 kp-row">
            <div class="kp-col-4">
                <div class="groupmaterial text">
                    <?= Html::input('date', PersonalProfileForm::ATTR_PASSPORT_BDAY_PLACE, $model->passport_bday_place, [
                        'class' => "n addproduct",
                        'placeholder' => "01.01.2007",
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4 top">
            <div class="box-text-titles"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PASSPORT_FILE); ?>:</div>
        </div>
        <div class="kp-col-8">
            <div class="groupmaterial file">
                <ul class="list-load"></ul>
                <?= Html::input('file', PersonalProfileForm::ATTR_PASSPORT_FILE, $model->passport_file, [
                    'class' => "addproduct",
                    'multiple' => "multiple",
                ]) ?>
                <button class="file_load">Загрузить документ</button>
            </div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-12 line">
            <div class="this-line">Адрес регистрации</div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4">
            <div class="box-text-titles"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PASSPORT_RESIDENT_ADDRESS); ?>:</div>
        </div>
        <div class="kp-col-8">
            <div class="groupmaterial text">
                <?= Html::input('text', PersonalProfileForm::ATTR_PASSPORT_RESIDENT_ADDRESS, $model->passport_resident_address, [
                    'class' => "addproduct",
                ]) ?>
            </div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4"></div>
        <div class="kp-col-8">
            <div class="groupmaterial checkbox">
                <label for="ch"> <span><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PASSPORT_IS_SAME_ADDRESS); ?></span>
                </label>
                <?= Html::input('checkbox', PersonalProfileForm::ATTR_PASSPORT_IS_SAME_ADDRESS, 1, [
                    'class' => "addproduct",
                    'id' => 'ch',
                ]) ?>
                <div class="square"><i class="i i-check-solid"></i></div>
                <label for="ch"></label>
            </div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4">
            <div class="box-text-titles"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PASSPORT_FACT_RESIDENT_ADDRESS); ?>:</div>
        </div>
        <div class="kp-col-8 full">
            <div class="groupmaterial text">
                <?= Html::input('text', PersonalProfileForm::ATTR_PASSPORT_FACT_RESIDENT_ADDRESS, $model->passport_fact_resident_address, [
                    'class' => "addproduct",
                ]) ?>
            </div>
            <div class="info"><i class="i i-info-solid"></i>
                <div class="text">По этому адресу будет проводиться вертификация</div>
            </div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-12 line">
            <div class="this-line tup"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PERSONAL_DATA_INN); ?>:</div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4">
            <div class="box-text-titles"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PERSONAL_DATA_SNILS); ?>:</div>
        </div>
        <div class="kp-col-8">
            <div class="groupmaterial text">
                <?= Html::input('text', PersonalProfileForm::ATTR_PERSONAL_DATA_INN, $model->personal_data_inn, [
                    'class' => "n addproduct js-input-inn",
                    'placeholder' => "0000000000000"
                ]) ?>
            </div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4">
            <div class="box-text-titles"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PERSONAL_DATA_SNILS); ?>:</div>
        </div>
        <div class="kp-col-8">
            <div class="groupmaterial text">
                <?= Html::input('text', PersonalProfileForm::ATTR_PERSONAL_DATA_SNILS, $model->personal_data_snils, [
                    'class' => "n addproduct js-input-snils",
                    'placeholder' => "000-000-000 00"
                ]) ?>
            </div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4">
            <div class="box-text-titles"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PERSONAL_DATA_DRIVING_LICENSE); ?>:</div>
        </div>
        <div class="kp-col-8">
            <div class="groupmaterial text">
                <?= Html::input('text', PersonalProfileForm::ATTR_PERSONAL_DATA_DRIVING_LICENSE, $model->personal_data_driving_license, [
                    'class' => "n addproduct",
                ]) ?>
            </div>
        </div>
    </div>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4 top">
            <div class="box-text-titles"><?= $model->getAttributeLabel(PersonalProfileForm::ATTR_PERSONAL_DATA_ADDITIONAL_FILES); ?>:</div>
        </div>
        <div class="kp-col-8">
            <div class="groupmaterial file">
                <ul class="list-load"></ul>
                <?= Html::input('file', PersonalProfileForm::ATTR_PERSONAL_DATA_ADDITIONAL_FILES, $model->personal_data_additional_files, [
                    'class' => "addproduct",
                    'multiple' => "multiple",
                ]) ?>

                <button class="file_load">Загрузить документ</button>
            </div>
        </div>
    </div>
    <?php if (!empty($model->getFirstErrors())) : ?>
    <div class="line-addproduct kp-row errors">
        <div class="kp-col-4">
            <div class="box-text-titles">Ошибки:</div>
        </div>
        <div class="kp-col-8 js-form_errors">
            <?php  foreach ($model->getFirstErrors() as $error) : ?>
                <p><?= $error; ?></p>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="line-addproduct kp-row">
        <div class="kp-col-4"></div>
        <div class="kp-col-8">
            <button class="auth" type="submit">Отправить на вертификацию</button>
        </div>
    </div>
</div>
<?= Html::endForm() ?>