<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!-- APP CONTENT -->
    <main class="maincontent">
        <div class="container">
            <!-- plugin hook: 'frontend_header' -->
			<div class="content kosmetika" id="page-content" itemscope="" itemtype="http://schema.org/Store">

				<h1 class="category-name"><?php echo $arResult['NAME']?></h1>
				<div class="clear-both"></div>

				<div class="category-desc">
					<?php echo CHelper::resizePic( $arResult['PICTURE']['ID'], 150, 150, ' class="category-img" ' )?>
					<div class="category-text">
						<?php echo $arResult['DESCRIPTION']?>
					</div>
				</div>
				<div class="clear-both"></div>

				<div class="category-change-view">
					<div class="left">
						<?php CHelper::inc_file(SITE_TEMPLATE_PATH . '/inc/prices_for.php');?>
					</div>
					<div class="right">
						<div class="left sorting">
							<p><a href="#">По популярности</a> | <a href="#">По цене</a></p>
						</div>
						<div class="right">
							<ul class="catalogView">
								<li><span class="labelRoboto">Вид каталога:</span></li>
								<li id="btnTileView" class="active"></li>
								<li id="btnInlineView"></li>
								<li id="btnLineView"></li>
							</ul>
						</div>
					</div>
				</div>

				<div id="product-list" class="tile">

				<div class="left">
				</div>

				<div class="clearBlock"></div>

<ul class="thumbs product-list">
	<?php foreach ( $arResult['PRODS'] as $product ) {
		?>
		<li itemscope="" itemtype="http://schema.org/Product">
	        <a href="<?php echo $product['DETAIL_PAGE_URL']?>" title="<?php echo $product['NAME']?>">
	            <span class="skuSingle">1210<span>&nbsp;..</span></span>
	            <div class="image">
	                <div class="badge-wrapper">
	                    <?php echo CHelper::resizePic( $product['DETAIL_PICTURE'], 230, 230 )?>
	                </div>
	            </div>
	            <h5><span itemprop="name"><?php echo $product['NAME']?></span><div class="overflow-h"></div></h5>
	            <span itemprop="description" class="summary">
	            	<?php echo CHelper::titleCut( $product['PREVIEW_TEXT'], 100 );?>
	            </span>
           	</a>
			<div class="productVariants">
					<?php
					$offer_prices = [];
					foreach ( $product['OFFERS'] as $offer ) {

						$offer_prices[] = $offer['PRICE'];
						?>
	                    <div class="listThumbsFeature">
	                        <span class="productVariantsSku"><?php echo $offer['PROPERTY_32_VALUE']?></span>
	                        <span class="priceFeatureName"><?php echo $offer['PROPERTY_46_VALUE']?> мл</span>
	                        <span class="price nowrap"><?php echo $offer['PRICE']?> <span class="ruble">Р</span></span>
	                    </div>
                    <?php }?>
            </div>
            <div itemprop="offers" class="offers" itemscope="" itemtype="http://schema.org/Offer">
            		<div class="purchase">
	                    <div class="pricing">
	                    	<?php sort( $offer_prices );

	                    	$min = $offer_prices[0];
							$max = end( $offer_prices );

							if ( $min !== $max ) {?>
								<span class="price nowrap"><?php echo $min;?> <span class="ruble">Р</span>
								<span>&nbsp;..</span>
									<?php echo $max?> <span class="ruble">Р</span>
		                        </span>
		                        <div class="overflow-h"></div>
		                        <meta itemprop="priceCurrency" content="RUB">
		                    <?php } else {?>

								<span class="price nowrap">
									<?php echo $min;?> <span class="ruble">Р</span>
		                        </span>
		                        <div class="overflow-h"></div>
		                        <meta itemprop="priceCurrency" content="RUB">
		                    <?php }?>
	                    </div>
	                    <?php if ( count( $offer_prices ) > 1 ) {?>
	                    	<a class="buy" onclick="ProductPopup.show(<?php echo $product['ID']?>)" >Купить</a>
	                    <?php } else { ?>
	                    	<a class="buy" onclick="QuickCart.addItem(<?php echo $product['ID']?>, 1, <?php echo $min?>, '<?php echo $product['NAME']?>')">Купить</a>
	                    <?php } ?>
	                <link itemprop="availability" href="http://schema.org/InStock">
                </div>
            </div>
	    </li>
    <?php } ?>
</ul>
<?php echo $arResult['NAV_STRING']?>
</div></div></div></main>
<script>
	ProductPopup.addData(JSON.parse('<?php echo json_encode($arResult['POPUP_PRODUCTS'])?>'));
</script>
