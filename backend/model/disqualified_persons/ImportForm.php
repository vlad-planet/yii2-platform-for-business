<?php

namespace backend\models\disqualified_persons;

use common\yii\validators\FileValidator;
use common\yii\validators\RequiredValidator;

use yii\base\Model;

/**
 * Форма импорта дисквалифицированных персон
 *
 * @author Maxim Podberezhskiy
 */
class ImportForm extends Model
{
    /** @var string - file */
    public $fileToImport;
    const ATTR_FILE_TO_IMPORT = 'fileToImport';

    const POSSIBLE_FILE_TYPES = ['xls', 'xlsx'];

    /**
     * @return string
     */
    public function formName(): string
    {
        return '';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [static::ATTR_FILE_TO_IMPORT, RequiredValidator::class, RequiredValidator::ATTR_MESSAGE => 'Вы должны выбрать файл'],
            [
                static::ATTR_FILE_TO_IMPORT,
                FileValidator::class,
                FileValidator::ATTR_MAX_SIZE => 1024 * 1024 * 5,
                FileValidator::ATTR_MAX_FILES => 1
            ]

        ];
    }
}