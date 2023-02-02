<?php

namespace common\models\service;

use common\models\db\Files;

use Yii;
use yii\imagine\Image;

/**
 * Сервис для работы с изображениями
 *
 * @author Vladislav Bashlykov
 */
class ImageService
{
    /** Качество изображения */
    const QUALITY = 80;

    /**
     * Ресайз изображения по параметрам
     *
     * @param Files $file
     * @param integer $x
     * @param integer $y
     *
     * @return string
     *
     * @author Vladislav Bashlykov
     */
    static function resize(Files $file, int $x, int $y): string
    {
        $upload_dir = FileService::getUploadDir();
        $dir = $upload_dir . $file->dir . '/';

        $thumb =  $x . 'x' . $y . '_' . $file->name;

        if (!file_exists($dir . $thumb)) {
            Image::thumbnail($dir . $file->name, $x, $y)
                ->save(Yii::getAlias($dir . $thumb), ['quality' => static::QUALITY]);
        }

        $file->name = $thumb;

        return FileService::getPath($file);
    }
}