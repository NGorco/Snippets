<? 
get_header();

$cat_color = CUtil::cat_color($wp_query->queried_object->term_id);

wp_enqueue_script( "category-js", TPL . '/assets/js/category.js', array('jquery'),'', true );
?>
<script>
Data.max_num_pages = <?=$wp_query->max_num_pages?>
</script>

<!-- start:container -->
            <div class="container">
                
                <!-- start:page content -->
                <div id="page-content" class="clearfix">
                    
                    <!-- start:main -->
                    <div id="main" class="article">
                        
                        <!-- start:article-comments -->
                        <section id="archive-page" class="module-timeline">
                                        
                            <header>
                                <h2>
									<div class="cat-<?=$cat_color?>-header category-header">
                                		Поиск по сайту
                                	</div>
                                </h2>
                                <span class="borderline"></span>
                            </header>
                            
                            <!-- start:articles -->
                          
                            <div class="articles">                                
                               
                                 <? if(have_posts()){?>

                                	<?while(have_posts()): the_post();?>
										<? $date = new DateTime($post->post_date);?>
		                                <article>
		                                    <span class="published"><?=$date->format('d.m.Y')?> в <?=$date->format('H:i')?></span>
		                                    <a href="<? the_permalink()?>"><? the_post_thumbnail('medium'," class='img-responsive'" );?></a>
		                                    <div class="cnt">
		                                        <i class="bullet bullet-<?=$cat_color?>"></i>	                                      
		                                        <h3><a href="<? the_permalink()?>"><? the_title()?></a></h3>
		                                        <span class="text"><? the_excerpt()?></span>
		                                    </div>                                
		                                </article> 

                                	<?endwhile?>
                                <? }else {?>                                
                                    <h5>
                                        К сожалению, ничего не найдено.
                                    </h5>
                            <? } ?>
                                
                            </div>
                            <!-- end:articles -->                            
                            
							<? /* AJAX pagination

							<div id="temporary-ajax"></div>
							*/?>
                        </section>
                        <!-- end:archive-page -->
                        
						 <div class="text-center">
                        	<?php wp_paginate();?>	                                   
                        </div>

						<? /* AJAX pagination 

                        <? if($wp_query->max_num_pages > 1){?>
                        <!-- start:load-more -->
                        <div class="text-center">
                            <a href="#" class="show-more" title="Show More News">Смотреть дальше</a>
                        </div>
                        <!-- end:load-more -->
                        <?}?>

                        <*/?>
                        
                    </div>
                    <!-- end:main -->
                    
                    <? get_sidebar('category' );?>

                </div>
                <!-- end:page content -->
            
            </div>
            <!-- end:container -->

<? get_footer()?>