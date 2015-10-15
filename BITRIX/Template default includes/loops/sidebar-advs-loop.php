<div class="prod-block vip-prod"> 
	<span class="prod-block-top-label"></span>
	<div class="img-block">
		<a href="<?=$ITEM['DETAIL_PAGE_URL']?>">
			<?=CHelper::resizePic($ITEM['PROPERTY_1_VALUE'], 178, 237)?>
		</a>
	</div> 
	<div class="flat-catalog-view-specs-wrap">
	<? foreach ($ITEM['DISPLAY_PROPERTIES']['OPTIONS'] as $option) {?>
			<p class="flat-catalog-view-specs"><?=$option['NAME']?> <strong><?=$option['VALUE']?></strong></p>
		<?}?>
	</div>
	 <div class="price-block hover">
		<? CHelper::favourControl($ITEM['ID'])?>
		<span class="slider-price"><?=CHelper::price_format($ITEM['PROPERTY_2_VALUE'])?>р.</span>
		<span class="slider-price buy-btn" onclick="window.location = '<?=$ITEM['DETAIL_PAGE_URL']?>'"><a href="<?=$ITEM['DETAIL_PAGE_URL']?>">ПОДРОБНЕЕ</a></span>
	</div>		
</div>