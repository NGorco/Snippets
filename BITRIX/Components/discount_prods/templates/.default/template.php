<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<ul class="thumbs product-list">
<?
foreach ( $arResult['prods'] as $prod ) {

	?>
<li itemscope="" itemtype="http://schema.org/Product">
			<span class="sticker sticker-SPECIALOFFER"></span>
			<a href="<?php echo $prod['DETAIL_PAGE_URL']?>" title="Exotic Intansity">
				<div class="image">
					<div class="badge-wrapper">
						<?php echo CHelper::resizePic( $prod['DETAIL_PICTURE'], 250, 250 )?>
					</div>
				</div>
				<h5><span itemprop="name"><?php echo $prod['NAME']?></span><div class="overflow-h"></div></h5>
				<span itemprop="description" class="summary"><?php echo $prod['PREVIEW_TEXT']?></span>        </a>
				<div itemprop="offers" class="offers purchase addtocart" itemscope="" itemtype="http://schema.org/Offer">
						<div class="pricing">
							<?php if ( count( $prod['OFFERS'] ) > 1 ) {

								sort( $prod['OFFERS'] )?>
							<span class="price nowrap"><?php echo $prod['OFFERS'][0]?>
								<span class="ruble">Р</span>
								<span>&nbsp;..</span>
								<?php echo $prod['OFFERS'][1]?> <span class="ruble">Р</span>
							</span>
							<?php } else { ?>

								<span class="price nowrap">
									<?php echo $prod['OFFERS'][0]?><span class="ruble">Р</span>
								</span>
							<?php } ?>
						</div>

						<?php if ( count( $prod['OFFERS_PRICES'] ) > 1 ) {?>
		                	<a class="buy" onclick="ProductPopup.show(<?php echo $prod['ID']?>)" >Купить</a>
		                <?php } else { ?>
		                	<a class="buy" onclick="QuickCart.addItem(<?php echo $prod['ID']?>, 1, <?php echo $prod['OFFERS'][0]?>, '<?php echo $prod['NAME']?>')">Купить</a>
		                <?php } ?>
					<link itemprop="availability" href="http://schema.org/InStock">
				</div>
		</li>
	<?
}
?>
</ul>
<script>
	ProductPopup.addData(JSON.parse('<?php echo json_encode($arResult['prods_popup'])?>'));
</script>