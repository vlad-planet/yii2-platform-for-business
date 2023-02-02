<?php

use frontend\models\news_comments\NewsCommentsSearchResult;

/** @var $result NewsCommentsSearchResult */
?>

<?php if (!empty($result->items)): ?>
	<?php foreach ($result->items as $item): ?>
	<div class="item__newsbox_comment_item">
	    <div class="item__newsbox_comment_item_color">
	        <div class="color__box bgc2"> </div>
	    </div>
	    <div class="item__newsbox_comment_item_content">
	        <div class="title_comment">
	            <div class="main-title"><?= $item->author; ?></div>
	            <div class="date-title"><?= $item->date_create; ?></div>
	        </div>
	        <div class="text_comment"><?= $item->text; ?></div>
	        <div class="footer_comment">
	            <button class="icon" type=""><i class="i i-thumbs-up-solid"></i>
	            </button>
	            <div class="text">12</div>
	            <button class="icon" type=""><i class="i i-thumbs-down-solid"></i>
	            </button>
	        </div>
	    </div>
	</div>
	<?php endforeach; ?>
<?php endif; ?>
