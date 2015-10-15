<div class="post">
	<a class="img-link" href="<?=$ITEM['DETAIL_PAGE_URL']?>">
	<?=CHelper::resizePic($ITEM['DETAIL_PICTURE'], 220,130)?>
	</a>
	<a href="<?=$ITEM['DETAIL_PAGE_URL']?>">
	<p class="title"><?=$ITEM['NAME']?></p>
	</a>
	<p><?=CHelper::titleCut(strip_tags($ITEM['DETAIL_TEXT']),90)?></p>
</div>