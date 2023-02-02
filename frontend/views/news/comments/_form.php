<?php

use frontend\models\news_comments\NewsCommentsForm;
use frontend\controllers\NewsController;
use yii\helpers\Url;

/**
 * @var $news_id - ID Новости
 */
?>

<div class="item__newsbox_comment">
	<div class="item__newsbox_comment_create">
		<?php if (null === Yii::$app->user->identity): ?>
			Чтобы оставить комментарий, необходимо <a href="#" class="js--open-reg">зарегистрироваться</a> или <a href="#" class="js--open-auth">войти</a>
		<?php else: ?>

			<form action="<?= Url::to(NewsController::getUrlRoute(NewsController::ACTION_COMMENTS_CREATE, [NewsController::PARAM_ID => $news_id])); ?>" class="js--new-comment-form" method="POST">
				<div class="groupmaterial textarea">
					<textarea name="<?= NewsCommentsForm::ATTR_TEXT; ?>" id="comment-text" cols="30" rows="10" required></textarea>
				</div>
				<div class="comment-text">Комментарии проходят модерациию по правилам проекта</div>
				<button class="auth" type="submit" >Отправить</button>
			</form>

		<?php endif; ?>
	</div>
	<div class="item__newsbox_comment_list_comments" data-id_news_comments="<?= $news_id; ?>"></div>
</div>