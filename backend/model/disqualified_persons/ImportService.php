<?php

namespace backend\models\disqualified_persons;

use common\models\db\DisqualifiedPersons;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Yii;
use yii\web\UploadedFile;

/**
 * Сервис импорта disqualified_persons из xlsx
 * Class ImportService
 * @package backend\models\disqualified_persons
 *
 * @author Maxim Podberezhskiy
 */
class ImportService
{
    /** ['B'] => Номер записи РДЛ */
    const FIELD_NUMBER_IN_REESTR = 'B';

    /** ['C'] => ФИО дисквалифицированного лица */
    const FIELD_FIO = 'C';

    /** ['D'] => Дата рождения дисквалифицированного лица */
    const FIELD_B_DAY = 'D';

    /** ['E'] => Место рождения дисквалифицированного лица */
    const FIELD_B_PLACE = 'E';

    /** ['F'] => Наименование организации */
    const FIELD_COMPANY = 'F';

    /** ['G'] => ИНН организации */
    const FIELD_INN = 'G';

    /** ['H'] => Должность */
    const FIELD_POSITION = 'H';

    /** ['I'] => Статья КоАП РФ */
    const FIELD_ARTICLE_CODE = 'I';

    /** ['J'] => Наименование органа, составившего протокол об административном правонарушении */
    const FIELD_BODY_TITLE = 'J';

    /** ['K'] => ФИО судьи */
    const FIELD_JUDGE_FIO = 'K';

    /** ['L'] => Должность судьи */
    const FIELD_JUDGE_POSITION = 'L';

    /** ['N'] => Дата начала дисквалификации */
    const FIELD_DATE_START = 'N';

    /** ['O'] => Дата истечения срока дисквалификации */
    const FIELD_DATE_END = 'O';

    /**
     * Импорт файла
     *
     * @param UploadedFile $uploadedFile
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function import(UploadedFile $uploadedFile)
    {
        $extension = $uploadedFile->getExtension();
        if (in_array($extension, ImportForm::POSSIBLE_FILE_TYPES)) {
            $reader = IOFactory::createReader(ucfirst($extension));
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($uploadedFile->tempName);

            $worksheet = $spreadsheet->getActiveSheet();

            foreach ($worksheet->getRowIterator() as $row) {
                if ($row->getRowIndex() <= 3) { // заголовок таблицы
                    continue;
                }
                $this->parseRow($worksheet, $row);
            }
        }
    }

    /**
     * Разбор строки из файла
     *
     * @param Worksheet $worksheet
     * @param Row $row
     */
    private function parseRow(Worksheet $worksheet, Row $row)
    {
        $rowIndex = $row->getRowIndex();
        $getCellValue = function (string $column) use ($worksheet, $rowIndex) {
            return $worksheet->getCell($column . $rowIndex)->getValue();
        };
        /** создадим запись в таблице disqualified_persons */
        $disqualifiedPerson = new DisqualifiedPersons();
        $disqualifiedPerson->number_in_reestr   = $getCellValue(static::FIELD_NUMBER_IN_REESTR);
        $disqualifiedPerson->fio                = $getCellValue(static::FIELD_FIO);
        $disqualifiedPerson->b_day              = Yii::$app->formatter->asDate($getCellValue(static::FIELD_B_DAY), 'php:Y-m-d');
        $disqualifiedPerson->b_place            = $getCellValue(static::FIELD_B_PLACE);
        $disqualifiedPerson->company            = $getCellValue(static::FIELD_COMPANY);
        $disqualifiedPerson->inn                = $getCellValue(static::FIELD_INN);
        $disqualifiedPerson->position           = $getCellValue(static::FIELD_POSITION);
        $disqualifiedPerson->article_code       = $getCellValue(static::FIELD_ARTICLE_CODE);
        $disqualifiedPerson->body_title         = $getCellValue(static::FIELD_BODY_TITLE);
        $disqualifiedPerson->judge_fio          = $getCellValue(static::FIELD_JUDGE_FIO);
        $disqualifiedPerson->judge_position     = $getCellValue(static::FIELD_JUDGE_POSITION);
        $disqualifiedPerson->date_start         = Yii::$app->formatter->asDate($getCellValue(static::FIELD_DATE_START), 'php:Y-m-d');
        $disqualifiedPerson->date_end           = Yii::$app->formatter->asDate($getCellValue(static::FIELD_DATE_END), 'php:Y-m-d');

        if(true === $disqualifiedPerson->validate()){
            $disqualifiedPerson->save();
        }
    }
}