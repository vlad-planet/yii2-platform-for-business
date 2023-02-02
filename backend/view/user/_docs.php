<?php

use backend\models\user_documents\UserDocumentItem;

/** @var $docs UserDocumentItem[] */
?>

<div class="table-data">
    <div class="table-data-container">
        <div class="table-header">
            <div class="title-header">Документы пользователя</div>
        </div>
        <?php if (!empty($docs)) : ?>
        <div class="table-body">
            <table class="personal-style">
                <thead>
                <tr>
                    <th class="tl">Дата</th>
                    <th class="tl">Название</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($docs as $item) : ?>
                    <tr>
                        <td class="tl font-roboto"><?= $item->date_create; ?></td>
                        <td class="tl"><?= $item->name; ?></td>
                        <td>
                            <a class="icon ma" type="" href="<?= $item->url; ?>" target="_blank">
                                <i class="i i-download"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>