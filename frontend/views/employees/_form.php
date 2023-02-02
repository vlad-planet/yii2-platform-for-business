<?php

use frontend\controllers\EmployeesController;
use frontend\models\employees\EmployeesForm;
use frontend\models\employees\EmployeesService;
use frontend\models\actives\ActiveService;

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\db\ActiveEmployees */
/* @var $form yii\widgets\ActiveForm */
?>

<form
        class="addproduct__form"
        action="<?= Url::to(EmployeesController::getUrlRoute(EmployeesController::ACTION_CREATE)); ?>"
        method="POST"
        onsubmit="AjaxForms.Request(this); return false;"
>
        <div class="lines-addproduct">
        <div class="line-addproduct kp-row">
            <div class="kp-col-4">
                <div class="box-text-titles">ФИО:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial text">
                    <input class="addproduct " type="text" placeholder="" name="<?= EmployeesForm::ATTR_FIO; ?>" id=""/>
                </div>
            </div>
        </div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4">
                <div class="box-text-titles">Телефон:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial text">
                    <input class="addproduct" type="text" placeholder="" name="<?= EmployeesForm::ATTR_PHONE; ?>" id=""/>
                </div>
            </div>
        </div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4">
                <div class="box-text-titles">E-mail:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial text">
                    <input class="addproduct" type="text" placeholder="" name="<?= EmployeesForm::ATTR_EMAIL; ?>" id=""/>
                </div>
            </div>
        </div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4">
                <div class="box-text-titles">Дата приема на работу:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial text">
                    <input class="n addproduct" type="date" placeholder="" name="<?= EmployeesForm::ATTR_HIRE_DATE; ?>" id=""/>
                </div>
            </div>
        </div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4">
                <div class="box-text-titles">Должность:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial text">
                    <input class="addproduct" type="text" placeholder="" name="<?= EmployeesForm::ATTR_POSITION; ?>" id=""/>
                </div>
            </div>
        </div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4">
                <div class="box-text-titles">Подразделение:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial select">
                    <input class="addproduct" type="text" placeholder="" name="<?= EmployeesForm::ATTR_DEPARTMENT; ?>" id=""/>
                </div>
            </div>
        </div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4">
                <div class="box-text-titles">Актив:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial select">
                    <select class="addproduct select2" name="<?= EmployeesForm::ATTR_ACTIVE_ID ?>" data-placeholder="--- Выбрать ---">
                        <option value="" disabled selected></option>
                        <?php foreach (ActiveService::getListForSelect() as $key => $value): ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4">
                <div class="box-text-titles">Руководитель:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial select">
                    <select class="addproduct select2" name="<?= EmployeesForm::ATTR_MANAGER ?>" data-placeholder="--- Выбрать ---">
                        <option value="" disabled selected></option>
                        <?php foreach (EmployeesService::getListForSelect() as $key => $value): ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4">
                <div class="box-text-titles">Оклад:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial text">
                    <input class="n addproduct" type="text" placeholder="" name="<?= EmployeesForm::ATTR_SALARY; ?>" id=""/>
                </div>
            </div>
        </div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4">
                <div class="box-text-titles">Ставка:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial text">
                    <input class="n addproduct" type="text" placeholder="" name="<?= EmployeesForm::ATTR_RATE; ?>" id=""/>
                </div>
            </div>
        </div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4">
                <div class="box-text-titles">Наличие премии:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial checkbox">
                    <input type="checkbox" name="<?= EmployeesForm::ATTR_BONUS_AVAIBLE; ?>" id="ch"/>
                    <div class="square"> <i class="i i-check-solid"></i></div>
                    <label for="ch"></label>
                </div>
            </div>
        </div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4">
                <div class="box-text-titles">Компенсация мобильной связи:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial checkbox">
                    <input type="checkbox" name="<?= EmployeesForm::ATTR_PHONE_COMPINSATION; ?>" id="ch"/>
                    <div class="square"> <i class="i i-check-solid"></i></div>
                    <label for="ch"></label>
                </div>
            </div>
        </div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4">
                <div class="box-text-titles">ДМС:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial checkbox">
                    <input type="checkbox" name="<?= EmployeesForm::ATTR_DMS; ?>" id="ch"/>
                    <div class="square"> <i class="i i-check-solid"></i></div>
                    <label for="ch"></label>
                </div>
            </div>
        </div>
        <!--
        <div class="line-addproduct kp-row">
            <div class="kp-col-4 top">
                <div class="box-text-titles">Комментарии/заметки:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial textarea">
                    <textarea class="addproduct" name="" id="" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4 top">
                <div class="box-text-titles">Личное дело:</div>
            </div>
            <div class="kp-col-8">
                <div class="groupmaterial file">
                    <ul class="list-load"> </ul>
                    <input class="addproduct" type="file" name="" id="" multiple="multiple"/>
                    <button class="file_load">Загрузить файл</button>
                </div>
            </div>
        </div>
        -->
        <div class="popup_footer_auth js-form_errors"></div>
        <div class="line-addproduct kp-row">
            <div class="kp-col-4"></div>
            <div class="kp-col-8">
                <button class="auth" type="submit">Добавить сотрудника</button>
            </div>
        </div>
    </div>
</form>