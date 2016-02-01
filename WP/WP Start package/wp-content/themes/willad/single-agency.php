<? 
/*
* Template name: Agency Single
*/
get_header();

if(!isset($_SESSION['agency_title_filter'])) $_SESSION['agency_title_filter'] = '';
if(!isset($_SESSION['agency_client_filter'])) $_SESSION['agency_client_filter'] = '';

$cat_id = '';
?>

<!-- start:container -->
            <div class="container">
                
                <!-- start:page content -->
                <div id="page-content" class="clearfix">
                    
                    <!-- start:main -->
                    <div id="main" class="article">
                        <? if(have_posts()):?>
                                <? while(have_posts()): the_post(); $cat_id = $post->post_category[0];?>
                                <? $cats = wp_get_post_terms($post->ID, 'agency_type');?>
                        <!-- start:article-post -->
                        <article id="article-post" class="cat-sports">
                            
                            <header>
                            	<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                                    <a href="http://willad.ru/" rel="v:url" property="v:title">Главная</a> / 
                                    <span typeof="v:Breadcrumb">
                                        <a href="/agency-catalog">Агенства</a>
                                    </span> /
                                    <? if(count($cats) > 0){?>
                                        <span rel="v:url" property="v:title" typeof="v:Breadcrumb">
                                            <a href="<?=get_term_link($cats[0]->term_id,'agency_type')?>"><?=$cats[0]->name?></a>
                                        </span> / 
                                    <?}?>
                                    <span class="current"><? the_title()?></span></div>
                                
                                <h1><? the_title()?></h1>
                            </header>                            

    	                    <section id="agencies-catalog" class="module-timeline">
                                <form action="/agency-catalog" class="form-inline agencies-filter-form">
                                    <div class="form-group">
                                        <label for="_id-agencies-catalog-form--agency-name" class="sr-only">Название агентства</label>
                                        <input type="text" name="agency_name" id="_id-agencies-catalog-form--agency-name" class="form-control" placeholder="Название агентства">
                                    </div>
                                    <div class="form-group">
                                        <label for="_id-agencies-catalog-form--agency-client" class="sr-only">Клиент</label>
                                        <input type="text" name="agencyclient" id="_id-agencies-catalog-form--agency-client" class="form-control" placeholder="Клиент">
                                    </div>
                                    <div class="form-actions">
                                        <span class="icon"><span class="fa fa-search"></span></span>
                                        <button type="submit" class="btn btn-default">Поиск</button>
                                    </div>
                                </form>
                                <ul class="agencies-cats">
                                    
                                    <? foreach($cats as $cat){ ?>
                                        <li><a href="<?=get_term_link($cat->term_id,'agency_type')?>" class="btn btn-default"><?=$cat->name?></a></li>
                                    <?}?>
                                </ul>
                                <section class="agency-card">
                                    <section class="agency-info clearfix">
                                        <div class="info-col">
                                            <div class="agency-thumbnail">
                                                <?=get_the_post_thumbnail() ?>
                                            </div>
                                            <ul class="agency-param-list">
                                                <li><strong>Принадлежит:</strong> <?=get('owner');?></li>
                                                <li><strong>Входит в состав:</strong> <?=get('part_of')?></li>
                                            </ul>
                                            <div class="agency-contacts">
                                                <h3 class="block-title">Контакты</h3>
                                                <div class="block-body">
                                                    <p><?=get('address');?><br>
                                                    <?=get('phone');?>
                                                    <br>
                                                    ___________________________________<br>
                                                    <?	$site = get('site');

                                                    	if($site != '')
                                                    	{
                                                    		if(stripos('http', $site) == -1)
                                                    		{
                                                    			$site = 'http://' . $site;
                                                    		}
                                                    		?>
															<!--noindex--><a href="<?=$site?>"><?=$site?></a><!--/noindex-->
                                                    		<?
                                                    	}
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="descr-col">
                                            <? the_excerpt()?>
                                            <div class="map-holder">
                                                <? mq_custom_map(get('address'), 307)?>
                                            </div>
                                        </div>
                                    </section>
                                    <? $port_items = get_group('port_item');

                                    
												if(count($port_items) > 0){?>
                                    <section class="agency-portfolio">
                                        <header>
                                            <h3>Портфолио</h3>
                                        </header>
                                        <div class="block-body">
                                            <div class="owl-gallery">
                                            	<?
                                                 foreach($port_items as $image)
												{?>
                                                <div class="item">
                                                    <a href="<?=$image['picture'][1]['original']?>" class="fancybox-group" rel="galleryID2"><img src="<?=$image['picture'][1]['original']?>" alt="" width="240" height="150"></a>
                                                    <span class="item-title"><?=$image['label'][1]?></span>
                                                </div>
                                                <?}?>
                                            </div>
                                        </div>
                                    </section>
                                    <?}?>
                                    <section class="agency-clients">
                                        <header>
                                            <h3>Клиенты</h3>
                                        </header>
                                        <div class="block-body">
                                            <!--ul>
                                                <li><a href="#">Subway</a></li>
                                                <li><a href="#">Jaguar</a></li>
                                                <li><a href="#">Adidas</a></li>
                                                <li><a href="#">Gazprom</a></li>
                                            </ul-->
                                            <?=get('clients')?>
                                        </div>
                                    </section>
                                    <section class="agency-extended-info">
                                        <header>
                                            <h3>О компании</h3>
                                        </header>
                                        <div class="block-body">
                                            <ul class="agency-param-list">
                                                <li><strong>Год основания:</strong> <?=get('mount_year')?></li>
                                                <li><strong>Штат:</strong> <?=get('empl_cnt')?></li>
                                                <li><strong>Услуги:</strong> <?=get('services')?></li>
                                            </ul>
                                            <div class="detail-info">
	                                            <? the_content();?>
                                                <div class="owl-gallery">
                                                    <? foreach(get_field('company_photos') as $about_item){?>
                                                        <div class="item">
                                                            <a href="<?=$about_item['original']?>" class="fancybox-group" rel="galleryID1"><img src="<?=$about_item['original']?>" alt="" width="247" height="164"></a>
                                                        </div>
                                                    <?}?>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <? $avards = get_group('avards');
                                    if(count($avards) > 0){?>
                                    <section class="agency-prizes">
                                        <header>
                                            <h3>Награды</h3>
                                        </header>
                                        <div class="block-body">
                                            <? foreach($avards as $avard){?>
                                            <div class="prize-item">
                                                <div class="prize-year"><?=$avard['avards_year'][1]?></div>
                                                <h4 class="prize-title"><?=$avard['avard_name'][1]?></h4>
                                                <div class="prize-descr">
                                                    <p><?=$avard['avards_value'][1]?></p>
                                                </div>
                                            </div>
                                            <?}?>
                                        </div>
                                    </section>
                                    <?}?>
                                </section>
                            </section>   

                            <!-- start:article footer -->
                            <footer>
                                <h3>Поделиться</h3>
                                <span class='st_facebook' displayText='Facebook'></span>
                                <span class='st_twitter' displayText='Tweet'></span>
                                <span class='st_googleplus' displayText='Google +'></span>
                                <span class='st_linkedin' displayText='LinkedIn'></span>
                                <span class='st_vkontakte' displayText='Vkontakte'></span>
                            </footer>
                            <!-- end:article footer -->                      
                        </article>
                        <?endwhile;?>
                            <?endif;?>
                        <!-- end:article-post -->    
                                     
                    </div>
                    <!-- end:main -->
                    
                     <? get_sidebar('single')?>

                </div>
                <!-- end:page content -->
            
            </div>
            <!-- end:container -->

<? get_footer()?>