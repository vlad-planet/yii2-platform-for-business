<?php

use common\models\db\MoneyBalanceLogs;

use frontend\models\money_balance\MoneyBalanceService;

use frontend\modules\personal\controllers\IndexController;
use frontend\modules\personal\helpers\MenuLinksHelper;
use frontend\modules\personal\models\money_balance_logs\MoneyBalanceLogsItem;
use frontend\modules\personal\models\money_balance_logs\MoneyBalanceLogsSearch;
use frontend\modules\personal\models\money_balance_logs\MoneyBalanceLogsSearchResult;

use frontend\widgets\profileMenu\ProfileMenuWidget;
use frontend\widgets\breadcrumbs\BreadcrumbsWidget;

use yii\helpers\Url;

/** @var $model MoneyBalanceLogsSearch */
/** @var $deposits MoneyBalanceLogsSearchResult */
/** @var $withdrawals MoneyBalanceLogsSearchResult */
/** @var $item MoneyBalanceLogsItem */

$this->title = 'Финансы';
$this->params['breadcrumbs'][] = [
    'label' => 'Личный кабинет',
    'url' => Url::to(IndexController::getUrlRoute(IndexController::ACTION_INDEX))
];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= BreadcrumbsWidget::widget([
	'homeLink' => [
		'label' => 'Главная ',
		'url' => Yii::$app->homeUrl,
	],
	'links' => $this->params['breadcrumbs'] ?? [],
])?>

<section class="section personal_main_content__inner">
    <div class="container tab-container">

        <!--Виджет меню профиля-->
        <?= ProfileMenuWidget::widget(['items' => MenuLinksHelper::getLinks()]) ?>

        <div class="tab-content">
            <div class="tab-content-item tab1">
                <div class="company_column_header">
                    <h5 class="fw500">Финансы</h5>
                </div>
                <div class="tab-section tab-finance-history-section">
                    <div class="finance-history-container">
                        <div class="your__balance">
                            <div class="left__balance">
                                <div class="box__balance">
                                    <div class="title">Ваш баланс:</div>
                                    <div class="money"> <span class="font-roboto"><?= MoneyBalanceService::getUserBalance() ?></span><i class="i i-rubonly"></i></div>
                                </div>
                            </div>
                            <div class="right__balance">
                                <div class="box__buttons">
                                    <button class="ownerbtn" type=""><span>Пополнить баланс</span>
                                    </button>
                                    <button class="ownerbtn" type=""><span>Вывести средства</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($deposits->items)): ?>
                        <div class="table-data">
                            <div class="table-data-container">
                                <div class="table-header">
                                    <div class="title-header">История поступлений</div>
                                </div>
                                <div class="table-body">
                                    <table class="personal-style">
                                        <thead>
                                        <tr>
                                            <th>Дата </th>
                                            <th>Наименование</th>
                                            <th>Сумма, руб.</th>
                                            <th>Документы</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($deposits->items as $deposit): ?>
                                                <tr>
                                                    <td><span class="font-roboto"><?= $deposit->date_create ?></span></td>
                                                    <td>Онлайн оплата</td>
                                                    <td><span class="font-roboto"><?= $deposit->value ?></span></td>
                                                    <td>
                                                        <button class="icon ma" type=""><i class="i i-download"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                        <?php if ($deposits->pagination->totalCount > $deposits->pagination->defaultPageSize): ?>
                                        <tr>
                                            <td colspan="4">
                                                <a class="underline tup cadres js--show-more-table s" href="#" title="показать еще 10" rel="follow">показать еще 10</a>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($withdrawals->items)): ?>
                        <div class="table-data">
                            <div class="table-data-container">
                                <div class="table-header">
                                    <div class="title-header">История списаний</div>
                                </div>
                                <div class="table-body">
                                    <table class="personal-style">
                                        <thead>
                                        <tr>
                                            <th>Дата </th>
                                            <th>Наименование</th>
                                            <th>Сумма, руб.</th>
                                            <th>Документы</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($withdrawals->items as $withdrawal): ?>
                                                <tr>
                                                    <td><span class="font-roboto"><?= $withdrawal->date_create ?></span></td>
                                                    <td>Онлайн оплата</td>
                                                    <td><span class="font-roboto"><?= $withdrawal->value ?></span></td>
                                                    <td>
                                                        <button class="icon ma" type=""><i class="i i-download"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                        <?php if ($withdrawals->pagination->totalCount > $withdrawals->pagination->defaultPageSize): ?>
                                        <tr>
                                            <td colspan="4"><a class="underline tup cadres js--show-more-table s" href="#" title="показать еще 10" rel="follow">показать еще 10</a>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>