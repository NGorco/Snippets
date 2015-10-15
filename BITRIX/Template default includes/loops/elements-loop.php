<div class="post">
	<?=CHelper::resizePic($ITEM['DETAIL_PICTURE'], 176, 157)?>
	<p class="title"><?=$ITEM['NAME']?></p>
	<p><?=CHelper::titleCut(strip_tags($ITEM['DETAIL_TEXT']), 140)?></p>
</div>