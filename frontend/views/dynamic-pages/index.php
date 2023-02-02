<?php

use frontend\models\dynamic_pages\DynamicPagesSearchResult;
use frontend\widgets\pagination\Pager;

/** @var $result DynamicPagesSearchResult */

?>
<?php if (!empty($result->items)): ?>
	<section class="section news__inner">
		<div class="container">
			<div class="section__content">
				<?php foreach ($result->items as $item): ?>
					<div class="box__news">
						<div class="box__content">
							<div class="box__content_stats">
								<div class="date_stats"> <i class="i i-calendar"></i><span class="date"><?= $item->date_create; ?></span></div>
								<div class="comment_stats"> <i class="i i-comment"></i><span class="comment"><?= $item->comments_count; ?> comments</span></div>
							</div>
							<div class="box__content_text">
								<div class="title_text"><?= $item->title; ?></div>
								<div class="box_text">
									<p><?= $item->text; ?></p>
								</div>
							</div>
							<div class="box__content_footer">
								<a href="<?= $item->detail_url; ?>" title="Название страницы" rel="follow" cl="">Подробнее</a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?= Pager::widget(['pagination' => $result->pagination]); ?>
		</div>
	</section>
<?php endif; ?>