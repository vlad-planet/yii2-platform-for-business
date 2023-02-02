<?php

namespace frontend\modules\personal;

use common\yii\base\Module;

/**
 * Модуль личного кабинета
 * @author Pavel Scherbich
 */
class PersonalModule extends Module
{
	const ID_CONFIG = 'personal';

	/**
	 * @var string
	 */
	public $controllerNamespace = 'frontend\modules\personal\controllers';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
	}
}