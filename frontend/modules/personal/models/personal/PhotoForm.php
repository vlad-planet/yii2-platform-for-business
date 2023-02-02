<?php

namespace frontend\modules\personal\models\personal;

use common\yii\validators\FileValidator;

use yii\base\Model;
use yii\validators\ImageValidator;
use yii\web\UploadedFile;

/**
 * Форма загрузки фото пользователя
 */
class PhotoForm extends Model
{
    /** @var UploadedFile */
    public $photo;
    public const ATTR_PHOTO = 'photo';

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [static::ATTR_PHOTO,
                FileValidator::class,
                FileValidator::ATTR_MAX_SIZE => 1048576], //1 Мб

            [static::ATTR_PHOTO, ImageValidator::class],
        ];
    }

    public function formName(): string
    {
        return '';
    }
}