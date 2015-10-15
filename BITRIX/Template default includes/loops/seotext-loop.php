<div class="seotext">
<?
$parts = explode("TEXTCUT", $ITEM['DETAIL_TEXT']);
echo $parts[0];
?>
<?if(count($parts) > 1 ){?>
<div class="show-more">Читать далее</div>
<span class="textpart2">
<?=$parts[1]?>
</span>
<?}?>
</div>