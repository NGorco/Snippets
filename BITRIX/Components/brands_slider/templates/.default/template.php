<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="brands-slider">
	<?php foreach ( $arResult['prods'] as $brand_group ) { ?>
		<div class="brands-element">
			   <a href="<?php echo $brand_group[0]['DETAIL_PAGE_URL']?>" class="bwWrapper">
			   <svg width="200px" height="100px" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
					 <filter id="grayscale">
						  <feColorMatrix type="saturate" values="0"/>
					 </filter>
					 <image filter="url(#grayscale)" width="100%" height="100%" xlink:href="<?php echo CFile::GetPath($brand_group[0]['DETAIL_PICTURE']);?>" />
				</svg>
			   </a>
			   <a href="<?php echo $brand_group[1]['DETAIL_PAGE_URL']?>" class="bwWrapper">
			   <svg width="200px" height="100px" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
					 <filter id="grayscale">
						  <feColorMatrix type="saturate" values="0"/>
					 </filter>
					 <image filter="url(#grayscale)" width="100%" height="100%" xlink:href="<?php echo CFile::GetPath($brand_group[1]['DETAIL_PICTURE']);?>" />
				</svg>
				</a>
		</div>
	<?php } ?>
</div>