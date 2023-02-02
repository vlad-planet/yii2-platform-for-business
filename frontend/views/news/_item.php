<?php

use frontend\models\news\NewsItem;
use frontend\controllers\NewsController;
use yii\helpers\Url;

/** @var $item NewsItem */
?>

<div class="item__newsbox">
    <div class="item__newsbox_body">
	        <a class="item__img_newsbox" href="#" title="<?= $item->title; ?>">
		        <img src="<?= $item->image_url_preview; ?>" alt="<?= $item->title; ?>" title="<?= $item->title; ?>"/>
	        </a>
        <div class="item__container_newsbox">
            <div class="item__container_news_body">
                <div class="item__container_newsbox_date"> <i class="i i-calendar"></i>
                    <div class="text"><?= $item->date_create; ?></div>
                </div>
                <a class="item__container_newsbox_title" href="<?= Url::to($item->detail_url); ?>"><?= $item->title; ?></a>
                <div class="item__container_newsbox_text"><?= $item->text; ?></div>
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
                         data-id_news="<?= $item->id; ?>"
                         data-url_get_comments="<?= Url::to(NewsController::getUrlRoute(NewsController::ACTION_COMMENTS, [NewsController::PARAM_ID => $item->id])); ?>">
	                    <i class="i i-comment"></i>
                        <div class="text"><?= $item->comments_count; ?> комментария</div>
                    </div>
                </div>
                <div class="item__container_news_right"><a class="read-more" href="<?= Url::to($item->detail_url); ?>" title="Подробнее" rel="follow">Подробнее</a>
                    <button class="icon" type=""><i class="i i-share"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?= $this->render('comments/_form', ['news_id' => $item->id]); ?>
</div>