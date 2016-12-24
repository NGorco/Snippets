<div class="recomend-products-slider">
	<?php foreach ( $arResult['prods'] as $prod ) {?>
	<div class="recomend-products-element">
		<div class="image">
			<a href="<?php echo $prod['DETAIL_PAGE_URL']?>" title="<?php echo $prod['NAME']?>">
				<div class="prod_image">
					<?php echo CHelper::resizePic( $prod['DETAIL_PICTURE'], 100, 100);?>
				</div>
				<h5>
					<span itemprop="name"><?php echo $prod['NAME']?></span>
				</h5>
				<meta itemprop="description" content="<?php $prod['PREVIEW_TEXT']?>">
			</a>
		</div>
		<div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">

			<form class="purchase addtocart" method="post" action="/cart/add/">
				<?php if ( count( $prod['OFFERS_PRICES'] ) > 1 ) {

					sort( $prod['OFFERS_PRICES'] )?>
					<span class="price nowrap"><?php echo $prod['OFFERS_PRICES'][0]?>
						<span class="ruble">Р</span>
						<span>&nbsp;..</span>
						<?php echo $prod['OFFERS_PRICES'][1]?> <span class="ruble">Р</span>
					</span>
				<?php } else { ?>

					<span class="price nowrap">
						<?php echo $prod['OFFERS_PRICES'][0]?><span class="ruble">Р</span>
					</span>
				<?php } ?>
				<?php if ( count( $prod['OFFERS_PRICES'] ) > 1 ) {?>
                	<a class="buy" onclick="ProductPopup.show(<?php echo $prod['ID']?>)" >Купить</a>
                <?php } else { ?>
                	<a class="buy" onclick="QuickCart.addItem(<?php echo $prod['ID']?>, 1, <?php echo $prod['OFFERS_PRICES'][0]?>, '<?php echo $prod['NAME']?>')">Купить</a>
                <?php } ?>
			</form>
		</div>
	</div>
	<?php } ?>
</div>
<script>
	ProductPopup.addData(JSON.parse('<?php echo json_encode($arResult['prods_popup'])?>'));
</script>