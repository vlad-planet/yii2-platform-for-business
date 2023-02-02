<?php

use frontend\controllers\EmployeesController;
use frontend\widgets\breadcrumbs\BreadcrumbsWidget;
use frontend\widgets\searchBlock\SearchBlockWidget;

/* @var $this yii\web\View */
/* @var $model common\models\db\ActiveEmployees */

$this->title = 'Добавить сотрудника';
$this->params['breadcrumbs'][] = [
    'label' => 'Сотрудники актива',
    'url'   => [EmployeesController::ACTION_INDEX]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= BreadcrumbsWidget::widget([
    'homeLink' => [
        'label' => 'Главная ',
        'url' => Yii::$app->homeUrl,
    ],
    'links' => $this->params['breadcrumbs'] ?? [],
]) ?>

<section class="section personal_main_content__inner">
    <div class="container tab-container">
        <ul class="tab-links">
            <li><a class="js--tab-1" href="#" title="Главная" rel="follow">Главная</a>
            </li>
            <li><a class="js--tab-2" href="#" title="Активы" rel="follow">Активы</a>
            </li>
            <li><a class="js--tab-3" href="#" title="Документы" rel="follow">Документы</a>
            </li>
            <li><a class="js--tab-4" href="#" title="Финансы" rel="follow">Финансы</a>
            </li>
            <li><a class="js--tab-5" href="#" title="Задачи" rel="follow">Задачи</a>
            </li>
            <li><a class="js--tab-6" href="#" title="Избранное" rel="follow">Избранное</a>
            </li>
            <li><a class="js--tab-7" href="#" title="Профиль" rel="follow">Профиль</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-content-item tab1">
                <div class="company_column_header">
                    <div class="company_color">
                        <div class="square_color bgc3"></div>
                    </div>
                    <div class="company_title">
                        <div class="title">ООО "Центр хранения данных"</div>
                    </div>
                </div>
                <div class="tab-section tab-addproduct-section">
                    <div class="addproduct-container">
                        <div class="title-header">Добавить сотрудника</div>
                        <?= $this->render('_form', [
                            'model' => $model,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>