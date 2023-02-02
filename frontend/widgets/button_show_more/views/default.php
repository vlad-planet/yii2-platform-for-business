<?php

use frontend\widgets\button_show_more\models\ButtonShowMoreResult;
use yii\helpers\Html;

/** @var ButtonShowMoreResult $result */

$this->registerJsFile(Yii::$app->params['staticPath'] . '/core/ButtonShowMore.js', ['depends' => 'frontend\assets\AppAsset']);
?>
<?php if ($result->url !== null): ?>
	<?= Html::a($result->label, $result->url, [
		'data-get_param_page' => $result->page_param_name,
		'data-page_number' => $result->page_number,
		'data-limit' => $result->limit,
		'class' => 'underline tup cadres js--show-more-btn s',
		'rel' => 'no follow'
	]); ?>
<?php endif; ?>