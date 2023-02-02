<?php

namespace common\services\pdf;

use common\services\pdf\models\Goods;
use common\services\pdf\models\Partner;

use kartik\mpdf\Pdf;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use Yii;
use yii\base\InvalidConfigException;

/**
 * Сервис, отвечающий за генерацию pdf-счета
 */
class InvoicePdfPrinterService
{
    /** @var int */
    public $invoice_number;

    /** @var Partner */
    public $partner;

    /** @var Goods */
    public $goods;

    /** @var string */
    public $pay_date;

    public function __construct(int $invoice_number, int $price)
    {
        $this->invoice_number = $invoice_number;
        $this->pay_date       = date('d.m.Y', strtotime("+3 days"));

        $partner          = new Partner();
        $partner->name    = 'ООО ИК «АЕОН»';
        $partner->inn     = '7704661909';
        $partner->kpp     = '770401001';
        $partner->address = '119146, Москва г, Фрунзенская 1-Я ул, дом № 3А, строение 6';

        $this->partner = $partner;

        $goods           = new Goods();
        $goods->name     = 'Консультационные услуги';
        $goods->quantity = 1;
        $goods->price    = $price;
        $goods->sum      = $goods->quantity * $goods->price;

        $this->goods = $goods;
    }

    /**
     * @return mixed
     */
    public function generatePreview(): mixed
    {
        $pdf = Yii::$app->pdf;

        $pdf->content = Yii::$app->controller->renderPartial('@common/services/pdf/views/invoice', [
            'number'   => $this->invoice_number,
            'partner'  => $this->partner,
            'goods'    => $this->goods,
            'pay_date' => $this->pay_date
        ]);

        return $pdf->render();
    }

    /**
     * @param string $filename
     * @return string
     * @throws MpdfException
     * @throws CrossReferenceException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws InvalidConfigException
     */
    public function savePdf(string $filename) {

        $content = Yii::$app->controller->renderPartial('@common/services/pdf/views/invoice', [
            'number'   => $this->invoice_number,
            'partner'  => $this->partner,
            'goods'    => $this->goods,
            'pay_date' => $this->pay_date
        ]);

        $pdf = new Pdf([
            'mode'        => Pdf::MODE_UTF8,
            'format'      => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_FILE,
            'filename'    => $filename,
            'content'     => $content,
        ]);

        return $pdf->render();
    }
}