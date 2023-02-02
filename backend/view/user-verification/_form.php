<?php

use backend\models\user_verification\UserVerificationForm;
use backend\controllers\UserVerificationController;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\db\UserVerification */
/* @var $userModel common\models\db\Users */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=d592eda8-f208-444c-9fec-b191de419547', [
    'position' => $this::POS_HEAD
]);

$this->registerJsFile('/static/js/YaMap.js', [
    'position' => $this::POS_HEAD
]);
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div id="demo"></div>
<div class="row">
    <div class="col-md-12">
        <label class="control-label" for="user_id">Верифицируемый пользователь</label>
        <p><?= $userModel->getFullShortName() ?></p>
        <?= $form->field($model, UserVerificationForm::ATTR_USER_ID)->hiddenInput(['value' => $userModel->id])->label(false) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, UserVerificationForm::ATTR_GEO_DATA)->hiddenInput(['maxlength' => 255, 'class' => 'form-control j-geoposition']) ?>
        <div id="map"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="j-images"></div>
        <?= $form->field($model, UserVerificationForm::ATTR_FILES . '[]')
            ->fileInput([
                'multiple' => 'multiple',
                'accept' => 'image/*',
                'onChange' => "UserForm.methods.previewPhoto(this)"
            ]) ?>
    </div>
</div>
<div class="form-group">
    <?= Html::a(
        'Отмена',
        Url::to(UserVerificationController::getUrlRoute(UserVerificationController::ACTION_INDEX)),
        ['class' => 'btn btn-danger']
    ); ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
<script>
    $(() => {
        UserForm.init()
        ymaps.ready(YaMap.init);
    })

    /**
     * Класс для работы с формой верификации
     */
    const UserForm = {
        methods: {
            /**
             * Получение геолокации
             */
            getMyLocation() { //собственно наша функция для определения местоположения
                if (navigator.geolocation) { //для начала надо проверить, доступна ли геолокация, а то еще у некоторых браузеры то древние. Там о таком и не слышали.
                    navigator.geolocation.getCurrentPosition(UserForm.methods.displayLocation); //если все ок, то вызываем метод getCurrentPosition и передаем ей функцию displayLocation.
                } else {
                    alert("Упс, геолокация не поддерживается"); //выведем сообщение для старых браузеров.
                }
            },
            /**
             * Установка геолокации в инпут
             * @param position
             */
            displayLocation(position) { //передаем в нашу функцию объект position - этот объект содержит ширину и долготу и еще массу всяких вещей.
                let latitude = position.coords.latitude, // излвекаем широту
                    longitude = position.coords.longitude; // извлекаем долготу
                $('.j-geoposition').val(`${latitude},${longitude}`)
            },
            /**
             * Превью выбранных фото
             * @param input
             */
            previewPhoto(input) {
                $('.j-preview').remove()
                let files = input.files || input.currentTarget.files,
                    reader = [],
                    images = $('.j-images'),
                    name;

                for (let i in files) {
                    if (files.hasOwnProperty(i)) {
                        name = `file${i}`;

                        reader[i] = new FileReader();
                        reader[i].readAsDataURL(input.files[i]);

                        images.append(`<img class="${name} j-preview" src="" title="${files[i].name}"/>`);

                        (function (name) {
                            reader[i].onload = function (e) {
                                $('.' + name).attr('src', e.target.result);
                            };
                        })(name);
                    }
                }
            }
        },
        init: () => UserForm.methods.getMyLocation()
    }
</script>

<style>
    img {
        display: inline-block;
        width: 100%;
        height: 100%;
        max-width: 200px;
        max-height: 200px;
        margin: 0 10px 10px 0;
    }

    #map {
        width: 600px;
        height: 400px;
        padding-bottom: 10px;
    }
</style>