<?php

namespace common\models\service;

use common\models\db\Files;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Сервис для работы с файлами
 *
 * @author Pavel Scherbich
 */
class FileService
{
	/**
	 * Папка в которой будет хранится файлы
	 */
	const BASE_DIR = '/web/upload/';

	/**
	 * Кол-во символов в подпапке
	 */
	const COUNT_SYMBOLS_IN_SUBDIR = 3;

	/**
	 * Сохранение файла на сервере и в БД
	 *
	 * @param UploadedFile $file
	 *
	 * @return bool|Files
	 * @author Pavel Scherbich
	 */
	public function save(UploadedFile $file)
	{
		$transaction = Yii::$app->db->beginTransaction();

		$result = false;

		$dir = $this->generateSubDir();

		$fileName = $this->generateName($file);

		$model = new Files;

		$model->name          = $fileName . '.' . $file->extension;
		$model->size          = $file->size;
		$model->original_name = $file->name;
		$model->dir           = $dir;

		$file->name = $fileName;

		if (true === $model->save() && true === $file->saveAs(static::getUploadDir() . $dir . '/' . $model->name)) {
			$result = $model;
			$transaction->commit();
		} else {
			$transaction->rollBack();
		}

		return $result;
	}

	/**
	 * Генерация директории где будет хранится файл
	 * @return string
	 * @author Pavel Scherbich
	 */
	public function generateSubDir(): string
	{
		$dir = mb_strtolower(Yii::$app->security->generateRandomString(static::COUNT_SYMBOLS_IN_SUBDIR));

		FileHelper::createDirectory(static::getUploadDir() . $dir, 0777);

		return $dir;
	}

	/**
	 * @param UploadedFile $file
	 *
	 * @return string
	 * @author Pavel Scherbich
	 */
	private function generateName(UploadedFile $file): string
	{
		return md5(rand(0, 2000) . $file->name . microtime());
	}

	/**
	 * @return string
	 * @author Pavel Scherbich
	 */
	public static function getUploadDir(): string
	{
		return Yii::getAlias('@storage') . static::BASE_DIR;
	}

	/**
	 * @param Files $model
	 *
	 * @return string
	 * @author Pavel Scherbich
	 */
	public static function getPath(Files $model): string
	{
		$result = '';

		$file = implode('/', [static::getUploadDir(), $model->dir, $model->name]);

		if (true === file_exists($file)) {
			$result = implode('/', [Yii::$app->params['sites']['storage'], 'upload', $model->dir, $model->name]);
		}

		return $result;
	}

	/**
	 * @param string $file_id
	 *
	 * @return string
	 * @author Pavel Scherbich
	 */
	public static function getById(string $file_id = null): string
	{
        if ($file_id != null) {
            return static::getPath(Files::findOne([Files::ATTR_ID => $file_id]));
        }
        return '';
	}
}