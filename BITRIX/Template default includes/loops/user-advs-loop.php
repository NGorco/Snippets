<div class="prod-block vip-prod"> 
<div class="custom-checkbox">
                                <input value="<?=$PROD['ID']?>" type="checkbox">
                                <span class="custom-chk"></span>                        
                            </div>
	<span class="prod-block-top-label"></span>
	<div class="img-block" style="  width: 176px;">
		<a href="<?=$ITEM['DETAIL_PAGE_URL']?>">
			<?=CHelper::resizePic($ITEM['PROPERTY_1_VALUE'], 178, 237)?>
		</a>
	</div> 
	<ul class="user-actions">
        <li><a href="/personal/advert-edit.php?ID=<?=$ITEM['ID']?>">Редактировать</a></li>
        <li><a>Премиум-размещение</a></li>
        <li><a>Сделать VIP-объявлением</a></li>
        <li><a>Выделить</a></li>
        <li><a>Поднять в списке</a></li>
       <?/* <li><a>Применить пакет услуг</a></li>*/?>
        <? if($ITEM['ACTIVE'] == "Y"){?>
        <li><a href="javascript:Handy.advAction(<?=$ITEM['ID']?>, 'unpublish')">Снять с публикации</a></li>
        <?}else{?>
        <li><a href="javascript:Handy.advAction(<?=$ITEM['ID']?>, 'publish')">Опубликовать</a></li>
        <?}?>
        <br>
        <li><a href="javascript:Handy.advAction(<?=$ITEM['ID']?>, 'remove'); window.location.reload()">Удалить</a></li>
    </ul>
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