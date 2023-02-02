<?php

/* @var $model common\models\db\Users */

use backend\controllers\UserController;
use backend\models\money_balance_logs\MoneyBalanceLogsSearch;
use common\models\db\Users;

use yii\helpers\Url;

$current_url = Url::current();

$buttons = [
    'Основная информация' => Url::to(UserController::getUrlRoute(UserController::ACTION_VIEW,
        [Users::ATTR_ID => $model->id])),
    'Баланс'              => Url::to(UserController::getUrlRoute(UserController::ACTION_BALANCE,
        [MoneyBalanceLogsSearch::ATTR_USER_ID => $model->id])),
    'Еще кнопка'          => '#',
    'Активы'              => '#',
    'Кнопка'              => '#',
];

?>

<div class="row">
    <div class="col-md-12">
        <div class="btn-group">

            <?php foreach ($buttons as $name => $url): ?>
                <a href="<?= $url ?>"
                   <?php $btn_class = str_contains($current_url, $url) ? 'btn-outline-success' : 'btn-success' ?>
                   class="btn user-detail-nav <?= $btn_class ?>">
                    <?= $name ?>
                </a>
            <?php endforeach; ?>

        </div>
    </div>
</div>

<style>
    .btn-group>.user-detail-nav.btn {
        margin-left: 5px;
    }
</style>