<? get_header();

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
                        <!-- start:article-post -->
                        <article id="article-post" class="cat-sports">
                            <? $cat = array_shift(get_the_category($post->ID ))?>                            
                            <header>
                            	<? CUtil::breadcrumb()?>
                                
                                <h1><? the_title()?></h1>
                            </header>                   
                            <? $curr_cat = array_shift((get_the_category($post->ID)));

                                if($curr_cat->term_id == 3)
                                {?>
                                <?php echo apply_filters( 'the_content', $post->post_excerpt );?>
                                <div class="overflow-hidden">
                                    <? MQ_Voting::showVote($post->ID);?>
                                    <style>
                                    #mq_voting{
                                        float:left;
                                        margin-right: 20px;
                                    }
                                    </style>
                                    
                                    <div class="video-descr">
                                        <? the_content();?>
                                    </div>
                                    </div>

                                    
                                    <?
                                }else{
                                    the_content();
                                }
                            ?>
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
                        <? if(get_option('horizontal_banner_inner') != ''){?>
                        <? $attach = get_post(get_option('horizontal_banner_inner'));
                       

                                if($attach->post_content != ''){?>
                                    <a href="<?=$attach->post_content?>">
                                        <img src="<?=$attach->guid?>" class="img-responsive" />                                      
                                    </a>
                                <?}else{?>     
                                    <a>
                                        <img src="<?=$attach->guid?>" class="img-responsive" />                                       
                                    </a>
                                <?}?>
                                <br>
                                 <?}?>
                        <?endwhile;?>
                            <?endif;?>

                        <!-- end:article-post -->
                        
                        <!-- start:related-posts -->
                        <section class="news-lay-3 bottom-margin">
                                            
                            
                            <? 
                                $related = new WP_Query(array('cat'=> $cat_id, 'posts_per_page' => 3, 'sortby' => 'rand') );
                                $category = get_category($cat_id );
                            ?>
                            <? if($related->post_count > 0){?>   
                            <header>
                                <h2><a >Новости по теме</a></h2>
                                <span class="borderline"></span>
                            </header>

                            <?}?>
                            <!-- start:row -->
                            <div class="row">
                                <? while($related->have_posts()){
                                    $related->the_post();?>
                                <!-- start:article -->
                                <article class="col-md-4 cat-<?=CUtil::cat_color($cat_id)?>">
                                   
                                    <div class="thumb-wrap relative">
                                        <a href="<? the_permalink()?>">
                                            <? CUtil::thumbDiv('', '', 180, 'img-responsive')?>
                                        </a>
                                        <a href="<?=get_category_link($category );?>" class="theme">
                                            <?=$category->name?>
                                        </a>
                                    </div>
                                    <span class="published"><? the_date()?></span>
                                    <h3><a href="<? the_title()?>"><? the_title()?></a></h3>
                                    
                                </article>
                                <!-- end:article -->
                                <?}
                                wp_reset_query();?>                               
                            
                            </div>
                            <!-- end:row -->

                        </section>
                        <!-- end:related-posts -->    


                                                <!-- start:article-comments -->
                        <section id="article-comments">
                            
                            <!-- start:comments-list -->
                            <?php comments_template(); ?>
                            <!-- end:comments-list -->

                        </section>
                        <!-- end:article-comments -->    
                                     
                    </div>
                    <!-- end:main -->
                    
                     <? get_sidebar('single')?>

                </div>
                <!-- end:page content -->
            
            </div>
            <!-- end:container -->

<? get_footer()?>