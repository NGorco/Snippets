<div class="advert">
    <div class="feat-adv-img">
    	<a href="<?=$ITEM['DETAIL_PAGE_URL']?>">
		<?=CHelper::resizePic($ITEM['PROPERTY_1_VALUE'], 80, 93);?>
		</a>
    </div>
    <p class="title"><a href="<?=$ITEM['DETAIL_PAGE_URL']?>"><?=$ITEM['NAME']?></a></p>
    <? if($opt['VALUE']!=''){?>
    <p class="adress"><? $opt = CHelper::featAdvOptDetail($ITEM['ID']);?>

	<?=$opt['NAME']?>:<?=$opt['VALUE']?>
    </p>
    <?}?>
</div>
&nbsp;