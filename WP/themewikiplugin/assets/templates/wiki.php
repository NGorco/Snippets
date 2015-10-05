<!DOCTYPE html>
<html>
<head>
<title><?=themewiki_get_option('wiki_page_title')?></title>
<link rel='stylesheet' href='<?=plugins_url('themewikiplugin') . '/assets/css/wiki.css'?>' />
<link rel='stylesheet' href='<?=plugins_url('themewikiplugin') . '/assets/css/prettyPhoto.css'?>' />

<script src='<?=plugins_url('themewikiplugin') . '/assets/js/jquery-1.6.1.min.js'?>'></script>
<script src='<?=plugins_url('themewikiplugin') . '/assets/js/jquery.prettyPhoto.js'?>'></script>
<script src='<?=plugins_url('themewikiplugin') . '/assets/js/common.js'?>'></script>
</head>
<body class="sticky-header">
<header id="Header" style="background-image: url('<?=themewiki_get_option('header_background')?>')">
			
	    <div id="Top_bar">
	        <div class="container">
	            <div class="column one">
	            
					<a style="background: url('<?=themewiki_get_option('header_logo')?>') no-repeat" id="logo" href="#"></a>
					<?

					$menu_id = themewiki_get_option('header_top_menu');

					 if(!empty($menu_id)){
					 	wp_nav_menu(Array('menu'=> $menu_id, 'container'=>'','menu_class'=>'addons_menu'));
					 	}?>
	            </div>
	        </div>
	    </div>
		
	    <div id="Slogan">
	        <div class="container">
	            <div class="column one">
	               <?=themewiki_get_option('header_main_text')?>
	            </div>
	        </div>
	    </div>

	</header>
<div id="Categories" class="">
        <div class="container">
            <div class="column one">
				<ul class="categories_menu">
					<?  $categories = get_posts(array('post_type'=>'wiki','orderby'=>'menu_order', 'order'=>'asc', 'post_parent'=>0));
						
						foreach ($categories as $category) {

							$items = get_posts(array('post_type'=>'wiki','orderby'=>'menu_order','order'=>'asc', 'post_parent'=>$category->ID));
							?>
							<li class="item_<?=$category->ID?> <?=(count($items)>0 ? 'submenu' : '')?>">
							<a href="#<?=$category->post_name?>"><span class="icon" style><?=get_the_post_thumbnail( $category->ID, 'thumbnail' )?></span><p><?=$category->post_title?></p></a>
							<? 
								if(count($items)>0):?>
									<ul>
									<?foreach($items as $item):?>
										<li><a href="#<?=$item->post_name?>"><?=$item->post_title?></a></li>
									<?endforeach;?>
									</ul>
								<?endif;?>
						<?}?>
				</ul>
            </div>
        </div>
    </div>
    <div id="Content">		
		
		<div class="container">
		
			<!-- Started doc from here -->
			<? $cnt = 0; foreach ($categories as $category) {
					$cnt++;
					$items = get_posts(array('post_type'=>'wiki','orderby'=>'menu_order','order'=>'asc', 'post_parent'=>$category->ID));
					?>
					<div class="column one" id="<?=$category->post_name?>">
						<h2><?=$cnt?>. <?=$category->post_title?></h2>
						<div class="item_content">
							<?=$category->post_content?>
						</div>	

					</div>
					<? 
						if(count($items)>0):		
							$dcnt = 0;					
							foreach($items as $item):$dcnt++;?>
								<div class="column one sec_lvl" id="<?=$item->post_name?>">
									<h3><?=$cnt?>.<?=$dcnt?> <?=$item->post_title?></h3>
									<div class="item_content">
										<?=$item->post_content?>
									</div>
								</div>
								<?
									$sec_items = get_posts(array('post_type'=>'wiki','orderby'=>'menu_order','order'=>'asc', 'post_parent'=>$item->ID));
									
									$tcnt = 0;					
									foreach($sec_items as $sec_item):$tcnt++;?>
			                           <div class="column one-second thr_lvl" id="<?=$sec_item->post_name?>">

										<h4><?=$cnt?>.<?=$dcnt?>.<?=$tcnt?> <?=$sec_item->post_title?></h4>
										
										<p>
											</p><div class="image-frame cut-image">
												<a href="doc-images/builder-items/accordion_admin.png" rel="prettyphoto">
													<img alt="accordion item" src="doc-images/builder-items/accordion_admin.png" class="scale-with-grid">
												</a>
											</div>
										<p></p>				
										
 										<div class="item_content">
 											<?=$sec_item->post_content?>
 										</div>
									
									</div>
									<? endforeach;?>
							<? endforeach;?>
						<? endif?>
				<?}?>

	</div>
		
	<footer id="Footer">
		<div class="wrapper">

		</div>
	</footer>


</div>