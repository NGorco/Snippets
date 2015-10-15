<div class="prod-block <?=($ITEM['DISPLAY_PROPERTIES']['ADVERT_STATUS'] > 0) ? "vip-prod" : ''?>"> 
		<span class="prod-block-top-label"></span>
		<div class="img-block">

			<a href="<?=$ITEM['DETAIL_PAGE_URL']?>">
				<?=CHelper::resizePic($ITEM['DISPLAY_PROPERTIES']['ADD_PICS'][0], 178, 237)?>
			</a>
			<? if(count($ITEM['DISPLAY_PROPERTIES']['ADD_PICS'])>0){?>
				<span class="pic-cnt">
					<?=count($ITEM['DISPLAY_PROPERTIES']['ADD_PICS'])?>
				</span>
				<?}?>
		</div> 
		<div class="flat-catalog-view-specs-wrap">
		<? foreach ($ITEM['DISPLAY_PROPERTIES']['OPTIONS'] as $option) {?>
			<p class="flat-catalog-view-specs"><?=$option['NAME']?> <strong><?=$option['VALUE']?></strong></p>
		<?}?>		
		</div>
		 <div class="price-block hover">
			<? CHelper::favourControl($ITEM['ID'])?>
			<span class="slider-price"><?=CHelper::price_format($ITEM['DISPLAY_PROPERTIES']['PRICE'])?>р.</span>
			<span class="slider-price buy-btn" onclick="window.location = '<?=$ITEM['DETAIL_PAGE_URL']?>'"><a href="<?=$ITEM['DETAIL_PAGE_URL']?>">ПОДРОБНЕЕ</a></span>
		</div>		
	</div>