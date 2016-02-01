<?
 get_header();
?>

<!-- start:container -->
            <div class="container">
                
                <!-- start:page content -->
                <div id="page-content" class="clearfix">
                    
                    <!-- start:main -->
                    <div id="main" class="article">
                        <? if(have_posts()):?>
                                <? while(have_posts()): the_post();?>
                        <!-- start:article-post -->
                        <article id="article-post" class="cat-sports">
                           
                            <header>
                                <? CUtil::breadcrumb()?>
                                
                                <h1><? the_title()?></h1>
                            </header>   
                           
                            <? the_content();?>
                            
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