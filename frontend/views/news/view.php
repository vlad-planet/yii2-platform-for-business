<?php

use frontend\models\news\NewsSearchView;
use frontend\widgets\breadcrumbs\BreadcrumbsWidget;
use frontend\controllers\NewsController;

use yii\helpers\Url;

$this->registerJsFile(Yii::$app->params['staticPath'] . '/js/NewsComments.js', ['depends' => 'frontend\assets\AppAsset']);

/** @var $model NewsSearchView */
$this->title = $model->result->title;
$this->params['breadcrumbs'][] = [
    'label' => 'Новости',
    'url'   => [Url::to(NewsController::getUrlRoute(NewsController::ACTION_INDEX))]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= BreadcrumbsWidget::widget([
    'homeLink' => [
        'label' => 'Главная ',
        'url' => Yii::$app->homeUrl,
    ],
    'links' => $this->params['breadcrumbs'] ?? [],
])?>

<section class="section listnews_main__inner">
	<div class="container">
		<div class="item__newsbox text">
			<div class="item__newsbox_body">
				<div class="newsbox__title-header"><?= $model->result->title ;?></div>
				<div class="item__container_newsbox">
					<div class="item__container_news_body">
						<div class="newsbox__header__indexes">
							<div class="header__indexes_date"> <i class="i i-calendar"></i>
								<div class="text"><?= $model->result->date_create; ?></div>
							</div>
							<div class="header__indexes_date"> <i class="i i-comment"></i>
								<div class="text"><?= $model->result->comments_count; ?> комментария</div>
							</div>
						</div>
						<div class="item__container_newsbox_text">
							<?= $model->result->text; ?>
						</div>
					</div>
					<div class="item__container_news_footer">
						<div class="item__container_news_left">
							<div class="item__container_news_likes">
								<button class="icon" type=""><i class="i i-thumbs-up-solid"></i>
								</button>
								<div class="text">12</div>
								<button class="icon" type=""><i class="i i-thumbs-down-solid"></i>
								</button>
							</div>
							<div class="item__container_news_comments js--open-new-comment"
							     data-id_news="<?= $model->result->id; ?>"
							     data-url_get_comments="<?= Url::to(NewsController::getUrlRoute(NewsController::ACTION_COMMENTS, [NewsController::PARAM_ID => $model->result->id])); ?>">
								<i class="i i-comment"></i>
								<div class="text"><?= $model->result->comments_count; ?> комментария</div>
							</div>
						</div>
						<div class="item__container_news_right">
							<button class="icon" type=""><i class="i i-share"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<?= $this->render('comments/_form', ['news_id' => $model->result->id]); ?>
		</div>
	</div>
</section>