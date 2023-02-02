<?php

use common\services\pdf\models\Goods;
use common\services\pdf\models\Partner;

/** @var $number int */
/** @var $partner Partner */
/** @var $goods Goods */
/** @var $pay_date string */

?>

<div class="main">
    <table border="2" width="100%" style="border: 2px solid black; border-collapse: collapse; width: 100%; font-family: Arial;" cellpadding="2" cellspacing="2">
        <tr style="">
            <td colspan="2" rowspan="2" style="border: 1px solid black; min-height:13mm; width: 105mm;">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="height: 13mm;">
                    <tr>
                        <td valign="top">
                            <div>ПАО СБЕРБАНК г. Москва</div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="bottom" style="height: 3mm;">
                            <div style="font-size: 9pt;">Банк получателя</div>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="border: 1px solid black; min-height:7mm;height:auto; width: 25mm;">
                <div>БИK</div>
            </td>
            <td rowspan="2" style="border: 1px solid black; vertical-align: top; width: 60mm;">
                <div style=" height: 7mm; line-height: 7mm; vertical-align: middle;">044525225</div>
                <div>30101810400000000225</div>
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid black; width: 25mm;">
                <div>Сч. №</div>
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid black; min-height:6mm; height:auto; width: 50mm;">
                <div>ИНН  7704472556</div>
            </td>
            <td style="border: 1px solid black; min-height:6mm; height:auto; width: 55mm;">
                <div>КПП  770401001</div>
            </td>
            <td rowspan="2" style="border: 1px solid black; min-height:19mm; height:auto; vertical-align: top; width: 25mm;">
                <div>Сч. №</div>
            </td>
            <td rowspan="2" style="border: 1px solid black; min-height:19mm; height:auto; vertical-align: top; width: 60mm;">
                <div>40702810238000165222</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid black; min-height:13mm; height:auto;">

                <table border="0" cellpadding="0" cellspacing="0" style="height: 13mm; width: 105mm;">
                    <tr>
                        <td valign="top">
                            <div>ООО «ГЛЕНИКС ТЕХНОЛОДЖИС»</div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="bottom" style="height: 3mm;">
                            <div style="font-size: 9pt;">Получатель</div>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
    <br/>

    <div style="font-weight: bold; font-size: 14pt; padding-left:5px; font-family: Arial;">
        Счет № <?= $number ?> от <?= date('d.m.Y', time()) ?></div>
    <br/>

    <div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>

    <table width="100%" style="font-family: Arial;">
        <tr>
            <td style="width: 30mm; vertical-align: top;">
                <div style=" padding-left:2px; ">Поставщик:<br>(Исполнитель)</div>
            </td>
            <td>
                <div style="font-weight:bold;  padding-left:2px;">
                    ООО «ГЛЕНИКС ТЕХНОЛОДЖИС», ИНН 7704472556, КПП 770401001, 119146, Г.Москва,
                    вн.тер. г. Муниципальный Округ Хамовники, ул 1-Я Фрунзенская, дом 3А, строение 6, этаж
                    2, помещение 2
                </div>
            </td>
        </tr>
        <br>
        <tr>
            <td style="width: 30mm; vertical-align: top;">
                <div style=" padding-left:2px;">Покупатель:<br>(Заказчик)</div>
            </td>
            <td>
                <div style="font-weight:bold;  padding-left:2px;">
                    <?= $partner->name ?>, ИНН <?= $partner->inn ?>, КПП <?= $partner->kpp ?>, <?= $partner->address ?>
                </div>
            </td>
        </tr>
    </table>
    <br />
    <div style="font-family: Arial; font-size: 9pt;">Основание:</div>
    <table border="2" width="100%" cellpadding="2" cellspacing="2" style="border: 2px solid black; border-collapse: collapse; width: 100%; font-family: Arial;">
        <thead>
        <tr>
            <th style="border: 1px solid black; width:13mm; ">№</th>

            <th style="border: 1px solid black;">Товары (работы, услуги)</th>
            <th style="border: 1px solid black; width:20mm; ">Кол-во</th>
            <th style="border: 1px solid black; width:17mm; ">Ед.</th>
            <th style="border: 1px solid black; width:27mm;  ">Цена</th>
            <th style="border: 1px solid black; width:27mm;  ">Сумма</th>
        </tr>
        </thead>
        <tbody >
        <tr>
            <td style="border: 1px solid black; width:13mm; ">1</td>

            <td style="border: 1px solid black;"><?= $goods->name ?></td>
            <td style="border: 1px solid black; width:20mm; "><?= $goods->quantity ?></td>
            <td style="border: 1px solid black; width:17mm; ">Шт.</td>
            <td style="border: 1px solid black; width:27mm; text-align: center; "><?= Yii::$app->formatter->asDecimal($goods->price, 2) ?></td>
            <td style="border: 1px solid black; width:27mm; text-align: center; "><?= Yii::$app->formatter->asDecimal($goods->sum, 2) ?></td>
        </tr>
        </tbody>
    </table>

    <table style="font-family: Arial;" border="0" width="100%" cellpadding="1" cellspacing="1">
        <tr>
            <td></td>
            <td style="width:27mm; font-weight:bold;  text-align:right;">Итого:</td>
            <td style="width:27mm; font-weight:bold;  text-align: center; "><?= Yii::$app->formatter->asDecimal($goods->sum, 2) ?></td>
        </tr>
        <tr>
            <td></td>
            <td style="width:27mm; font-weight:bold;  text-align:right;">Итого НДС:</td>
            <td style="width:27mm; font-weight:bold;  text-align: center; "><?= Yii::$app->formatter->asDecimal($goods->sum * 13 / 100, 2) ?></td>
        </tr>
        <tr>
            <td></td>
            <td style="width:37mm; font-weight:bold;  text-align:right;">Всего к оплате:</td>
            <td style="width:27mm; font-weight:bold;  text-align: center; "><?= Yii::$app->formatter->asDecimal($goods->sum, 2) ?></td>
        </tr>
    </table>

    <br />
    <div style="font-family: Arial; font-size: 9pt;">
        Всего наименований 1 на сумму <?= Yii::$app->formatter->asDecimal($goods->sum, 2) ?> рублей.<br />
        Ноль рублей 00 копеек</div>
    <br/>
    <div style="font-family: Arial; font-size: 9pt;">
        <p>Оплатить не позднее <?= $pay_date ?>.<br>
        Оплата данного счета означает согласие с условиями поставки товара.<br>
        Уведомление об оплате обязательно, в противном случае не гарантируется наличие товара на складе.<br>
        Товар отпускается по факту прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта.</p>
    </div>
    <div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
    <div style="background: url('<!--url печати в png сюда-->');  background-repeat: no-repeat; padding: 30px 10px; height: 250px;">
        <br/>
        <br/>
        <table style="font-family: Arial;" border="0" width="100%" cellpadding="1" cellspacing="1">
            <tr>
                <td>Руководитель ____________________(Троценко Г. Р.)</td>
                <td>Бухгалтер ______________________(Троценко Г. Р.)</td>
            </tr>
        </table>

        <br/>

        <div style="width: 85mm;text-align:center;">М.П.</div>
        <br/>
    </div>
</div>
