<? get_header()?>

<!-- start:container -->
            <div class="container">
                
                <!-- start:page content -->
                <div id="page-content" class="clearfix">
                    
                    <!-- start:main -->
                    <div id="main" class="article">
                        
                        <!-- start:article -->
                        <article>
                            
                            <header>
                                <h2>
                                	<div class="cat-news-header category-header">
                                	<a href="#"><?=$wp_query->queried_object->name?></a>
                                	</div>
                                </h2>
                                <span class="borderline"></span>
                            </header>
                            
                            <!-- start:gallery section -->
                            <section>
                                
                                <div id="article-gallery" class="row video-category">
                                    <? if(have_posts()):?>

                                    	<?while(have_posts()): the_post();?>

		                                    <div class="col-xs-6 col-sm-3 col-md-4 text-center">
		                                        <article class="clearfix" id="video_post_<?=$post->ID?>">
		                                            <a rel="video">
		                                                <?php get_template_part( 'content-list', get_post_format() ); ?>                                                
		                                            </a>

		                                            <h5><a href="<? the_permalink()?>"><?php the_title(); ?></a></h5>
                                                    <? $rating = floor(get_post_meta($post->ID, 'mq_vote_rating', true) / get_option('rating_div')); 
                                                    if($rating > 5) $rating = 5;
                                                    ?>
                                                    <? MQ_Voting::showVote($post->ID);?>
                                                    <div class="review-rating">
                                                    <ul class="rating">
                                                        <? for($i = 0; $i < $rating; $i++){?>
                                                        <li class="li-rated"></li>
                                                        <?}?>

                                                        <? for($i = 0; $i < 5-$rating; $i++){?>
                                                        <li></li>
                                                        <?}?>
                                                    </ul>
                                                </div>
		                                        </article>
		                                    </div>
                                             <script>
                                                document.getElementById('video_post_<?=$post->ID?>').getElementsByTagName('iframe')[0].src += "&showinfo=0";                                                                    
                                            </script>
                                    	<?endwhile?>   
                                    <?endif?>                             
                                    
                                </div>
                                
                                <div class="text-center">
                                	<?php wp_paginate();?>	                                   
                                </div>
                                
                                
                            </section>
                            <!-- end:gallery section -->

                        </article>
                        <!-- end:article -->
                        
                    </div>
                    <!-- end:main -->               
                                           
                    <?php get_sidebar('category' ); ?>
                        
                                  
                </div>
                <!-- end:page content -->
            
            </div>
            <!-- end:container -->

<? get_footer()?>