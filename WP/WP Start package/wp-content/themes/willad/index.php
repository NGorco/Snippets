 <? get_header();?>
            <!-- start:page slider -->
            <div id="page-slider" class="clearfix">
                
                <!-- start:container -->
                <div class="container">
                    
                    <!-- start:carousel -->
                    <div id="slider-carousel">
                        
                        <!-- start:row -->
                        <div class="row">
                            
                            <!-- start:col -->
                            <div class="col-sm-8 todays-last-article main-page">
                                <? $posts = new WP_Query(array('posts_per_page' => 1));
                                if($posts->have_posts()):
                                while($posts->have_posts())
                                { 
                                    $today_post_category = array_shift(get_the_category($post));

                                    $posts->the_post();
                                    $url = CUtil::thumbUrl($post->ID, 'full');
                                    ?>    
        
                                    <article style="background: url(<?=$url?>) no-repeat; background-size: cover!important" class="linkbox large cat-sports">                               
                                        <a href="<? the_permalink();?>" class="main-block-main-page" id="video_post_<?=$post->ID?>">
                                            <? if($today_post_category->term_id == 3 && get_option('main_block_video') == 1){                                                
                                                    echo apply_filters( 'the_content', $post->post_excerpt );                                               
                                                    ?><script>
                                                        document.getElementById('video_post_<?=$post->ID?>').getElementsByTagName('iframe')[0].src += "&showinfo=0";                                                                    
                                                    </script><?
                                                }?>
                                            <div class="overlay">
                                                <h2><? the_title()?></h2>
                                                <? if($today_post_category->term_id != 3){?>
                                                <p><? the_excerpt();?></p>
                                                <?}?>
                                            </div>
                                        </a>
                                        <a href="#" class="theme">
                                            Сегодня
                                        </a>
                                    </article> 
                                <?}?>
                                <? endif?>                            
    
                            </div>
                            <!-- end:col -->
                            
                            <!-- start:col -->
                            <div class="col-sm-4 main-page-cats-sm">

                            	<?
                                $args = array('posts_per_page' => 1, 'offset' => 1);

                                if($today_post_category->term_id == $args['cat'])
                                {
                                    $args['offset'] = 2;
                                }

                                $frames = new WP_Query($args);?>
                                <? if($frames->have_posts()):
                                    while ($frames->have_posts()): $frames->the_post();
                                        $url = CUtil::thumbUrl($post->ID, 'medium');
                                        ?>
                                
                                    <? $post_category = array_shift(get_the_category($post)); ?>
                                <article onclick="window.location = '<?=get_category_link($post_category->term_id);?>'" style="cursor: pointer;background: url(<?=$url?>) no-repeat; background-size: cover!important" class="linkbox cat-<?=CUtil::cat_color($args['cat'])?>">
                                    <a href="<?=get_category_link($post_category->term_id);?>">                                       
                                        <div class="overlay">
                                            <h3><? the_title()?></h3>
                                        </div>
                                    </a>
                                </article>
                                <?
                                endwhile;
                                endif;?>                                

                                <?
                                $args = array('posts_per_page' => 1, 'offset' => 2);

                                if($today_post_category->term_id == $args['cat'])
                                {
                                    $args['offset'] = 3;
                                }

                                $frames = new WP_Query($args);?>
                                <? if($frames->have_posts()):while ($frames->have_posts()): $frames->the_post();?>
                                    <? $post_category = array_shift(get_the_category($post)); 

                                        $url = CUtil::thumbUrl($post->ID, 'medium');
                                        ?>
                                    <article onclick="window.location = '<?=get_category_link($post_category->term_id);?>'" style="cursor: pointer;background: url(<?=$url?>) no-repeat; background-size: cover!important" class="linkbox cat-<?=CUtil::cat_color($args['cat'])?>">
                                        <a href="<?=get_category_link($post_category->term_id);?>">                                          
                                            <div class="overlay">
                                                <h3><? the_title()?></h3>
                                            </div>
                                        </a>
                                    </article>    
                                <?
                                endwhile;
                                endif;?>                          

                                <!-- </article> -->
    
                            </div>
                            <!-- end:col -->
    
                        </div>
                        <!-- end:row -->
                      
                    </div>
                    <!-- end:slider-carousel -->
                    
                    <!-- start:slider-nav -->
                    <div class="slider-nav">
                        <a id="slider-prev" class="prev" href="#"><i class="fa fa-chevron-left"></i></a>
            <a id="slider-next" class="next" href="#"><i class="fa fa-chevron-right"></i></a>
                    </div>
                    <!-- end:slider-nav -->
                </div>
                <!-- end:container -->
                
            </div>
            <!-- end:page slider -->  
            <!-- start:container -->
            <div class="container main-page">
                
                <!-- start:page content -->
                <div id="page-content" class="clearfix">
                    
                    <!-- start:main -->
                    <div id="main">
                        
                        <!-- start:row -->
                        <div class="row ">
                            
                            <!-- start:col -->
                            <div class="col-md-9 separator-right left-main-page-column">    

                                <!-- start:row -->
                                <div class="row section-full-padding section-full last-news-blocks">                                     
                                    <?
                                    $args = array('posts_per_page' => 1, 'cat' => 1);
                                    $args['offset'] = 2;

                                    /*if($today_post_category->term_id == $args['cat'])
                                    {
                                    }*/

                                    $posts = new WP_Query($args);
                                    if($posts->have_posts()):
                                    while($posts->have_posts())
                                    { $posts->the_post();?>                                   
                                    <!-- start:col -->
                                    <div class="col-sm-6">
                                        <!-- start:article.linkbox -->
                                        <article class="linkbox cat-sports">
                                            <a href="<? the_permalink()?>">
                                               	<? CUtil::thumbDiv($post->ID, 'medium',205,'img-responsive')?>
                                                <div class="overlay">
                                                    <h3><? the_title()?></h3>
                                                </div>
                                            </a>
                                            <a href="<? the_permalink()?>" class="theme">
                                                Принты
                                            </a>
                                        </article>
                                        <!-- end:article.linkbox -->
                                    </div>
                                    <!-- end:col -->
                                    <?}?>                                
                                    <? endif?>

                                    <? 

                                    $args = array('posts_per_page' => 1, 'cat' => 4);
                                    $args['offset'] = 2;

                                    /*if($today_post_category->term_id == $args['cat'])
                                    {
                                    }*/

                                    $posts = new WP_Query($args);

                                    if($posts->have_posts()):
                                    while($posts->have_posts())
                                    { $posts->the_post();?>                                   
                                    <!-- start:col -->
                                    <div class="col-sm-6">
                                        <!-- start:article.linkbox -->
                                        <article class="linkbox cat-sports">
                                            <a href="<? the_permalink()?>">
                                                <? CUtil::thumbDiv($post->ID, 'medium',205,'img-responsive')?>
                                                <div class="overlay">
                                                    <h3><? the_title()?></h3>
                                                </div>
                                            </a>
                                            <a href="<? the_permalink()?>" class="theme">
                                                Брендинг
                                            </a>
                                        </article>
                                        <!-- end:article.linkbox -->
                                    </div>
                                    <!-- end:col -->
                                    <?}

                                    wp_reset_query();?>
                                    <? endif?>

                                </div>
                                <!-- end:row -->
                                <!-- start:row -->
                                <div class="row section-full-padding section-full last-news-blocks">
                                    <?
                                    $args = array('posts_per_page' => 1, 'cat' => 17);
                                    $args['offset'] = 1;

                                    /*if($today_post_category->term_id == $args['cat'])
                                    {
                                    }*/

                                    $posts = new WP_Query($args);

                                    if($posts->have_posts()):
                                    while($posts->have_posts())
                                    { $posts->the_post();?>                                   
                                    <!-- start:col -->
                                    <div class="col-sm-6">
                                        <!-- start:article.linkbox -->
                                        <article class="linkbox cat-sports">
                                            <a href="<? the_permalink()?>">
                                            	<? CUtil::thumbDiv($post->ID, 'medium',205,'img-responsive')?>                                               
                                                <div class="overlay">
                                                    <h3><? the_title()?></h3>
                                                </div>
                                            </a>
                                            <a href="<? the_permalink()?>" class="theme">
                                                Компании
                                            </a>
                                        </article>
                                        <!-- end:article.linkbox -->
                                    </div>
                                    <!-- end:col -->
                                    <?}?>
                                    <? endif;

                                    $args = array('posts_per_page' => 1, 'cat' => 18);
                                    $args['offset'] = 1;

                                    /*if($today_post_category->term_id == $args['cat'])
                                    {
                                    }*/

                                    $posts = new WP_Query($args);

                                    if($posts->have_posts()):
                                    while($posts->have_posts())
                                    { $posts->the_post();?>                                   
                                    <!-- start:col -->
                                    <div class="col-sm-6">
                                        <!-- start:article.linkbox -->
                                        <article class="linkbox cat-sports">
                                            <a href="<? the_permalink()?>">
                                                <? CUtil::thumbDiv($post->ID, 'medium',205,'img-responsive')?>
                                                <div class="overlay">
                                                    <h3><? the_title()?></h3>
                                                </div>
                                            </a>
                                            <a href="<? the_permalink()?>" class="theme">
                                                Статьи
                                            </a>
                                        </article>
                                        <!-- end:article.linkbox -->
                                    </div>
                                    <!-- end:col -->
                                    <?}

                                    wp_reset_query();?>
                                    <? endif?>
                                    
                                </div>
                                <!-- end:row -->

                                

                                <!-- start:1-st hor banner -->
                                <? if(get_option('main_page_hor_1') != '')
                                {?>
                                <? $attach = get_post(get_option('main_page_hor_1'));
                                if($attach->post_content != '')
                                    {?>
                                     <section class="section-full cat-business-light news-layout news-lay-1 relative ad-horizontal ">
                                        <a href="<?=$attach->post_content?>">
                                        	<div class="" style="height: 90px; background: url(<?=$attach->guid?>) no-repeat center center; background-size: cover"></div>                                            	
                                        </a>
                                    </section>   
                                  
                                    <?}else{?>  
                                         <section class="section-full cat-business-light news-layout news-lay-1 relative ad-horizontal">
                                            <div class="" style="height: 90px; background: url(<?=$attach->guid?>) no-repeat center center; background-size: cover"></div>
                                        </section>                                       
                                    <?}?>  
                                <?}?>  
                                <!-- end:1-st hor banner -->

                                <!-- start:videos -->
                                <section class="section-full cat-videos no-padding">
                                    <div class="container-fluid">
                                        <? 
                                        $args = array('posts_per_page' => 4, 'cat' => 3);

                                            if($today_post_category->term_id == $args['cat'])
                                            {
                                                $args['offset'] = 1;
                                            }

                                            $posts = new WP_Query($args);?>                                
                                        
                                            <? for($k = 0; $k < 2;$k++){?>
                                                <!-- start:row -->
                                                <div class="row">
                                                    <? for($i = 0; $i < 2;$i++){?>
                                                        <?if($posts->have_posts()): $posts->the_post();?>
                                                        <!-- start:col -->
                                                        <div class="col-sm-6">                                                    
                                                            <article class="linkbox cat-news">
                                                                <a href="<? the_permalink()?>">
                                                                    <div class="article-content" id="video_post_<?=$post->ID?>">
                                                                        <?php echo apply_filters( 'the_content', $post->post_excerpt  );?>
                                                                    </div>
                                                                    <script>
                                                                        document.getElementById('video_post_<?=$post->ID?>').getElementsByTagName('iframe')[0].src += "&showinfo=0";                                                                    
                                                                    </script>
                                                                    <div class="overlay">
                                                                        <h3><? the_title()?></h3>
                                                                    </div>
                                                                </a>
                                                                <a href="/category/roliki" class="theme">
                                                                    Ролики
                                                                </a>
                                                            </article>                        
                                                        </div>
                                                        <? endif?>
                                                    <?}?>
                                                    <!-- end:col -->
                                                    
                                                </div>
                                                <!-- end:row -->
                                            <?}?>
                                    </div>
                                </section>
                                <!-- end:videos -->   
                                <?/*<!-- start:2-st hor banner -->
                                <? if(get_option('main_page_hor_2') != '')
                                {?>
                                <? $attach = get_post(get_option('main_page_hor_2'));
                                if($attach->post_content != '')
                                    {?>
                                    <div class="ad col-md-6">
                                        <a href="<?=$attach->post_content?>">
                                        	<div class="" style="height: 175px; background: url(<?=$attach->guid?>) no-repeat center center; background-size: cover"></div>                                            	
                                        </a>
                                    </div>   
                                      
                                    <?}else{?>  
                                       <div class="ad col-md-6">
                                            <div class="" style="height: 175px; background: url(<?=$attach->guid?>) no-repeat center center; background-size: cover"></div>
                                        </div>                                    
                                    <?}?>  
                                <?}?>  
                                <!-- end:2-st hor banner -->
                                */?>
                                
                                
                                    
                                <!-- start:reviews -->
                                <section class="section-full top-padding cat-reviews news-layout news-lay-2">
                                    
                                    <header>
                                        <h2>Рейтинг видеороликов</h2>
                                        <span class="borderline"></span>
                                    </header>
                                    
                                    <!-- start:row -->
                                    <div class="row">
                                        <? $posts = new WP_Query(array('posts_per_page' => 4, 'cat' => 3, 'orderby' => 'rand'));

                                        if($posts->have_posts()): while($posts->have_posts()): $posts->the_post();?>
                                        <!-- start:col -->
                                        <div class="col-xs-6 col-sm-3">
                                            <!-- start:article.linkbox -->
                                            <article class="review">
                                                <a href="<?=get_post_permalink($post->ID );?>">
                                                    <? CUtil::thumbDiv('', 'medium', 80, 'img-bck img-responsive')?>
                                                    <h3><? the_title()?></h3>      
                                                </a>
                                                <? $rating = floor(get_post_meta($post->ID, 'mq_vote_rating', true) / get_option('rating_div')); 
                                                    if($rating > 5) $rating = 5;
                                                    ?>                                                   
                                                    <div class="review-rating">
                                                    <ul class="rating">
                                                        <? for($i = 0; $i < $rating; $i++){?>
                                                        <li class="li-rated"></li>
                                                        <?}?>

                                                        <? for($i = 0; $i < 5-$rating; $i++){?>
                                                        <li></li>
                                                        <?}?>
                                                    </ul>
                                            </article>
                                            <!-- end:article.linkbox -->
                                        </div>
                                        <!-- end:col -->   
                                        <? endwhile?>  
                                        <? endif ?>
                                                                       
                               
                                    </div>
                                    <!-- end:row -->
                                </section>
                                <!-- end:reviews -->      

                                                            <!-- start:business-news -->
                                <section class="section-full vizitki cat-business-light news-layout news-lay-1 relative">
                                    
                                    <a href="/visits/" class="theme cat-business">
                                        Визитки агентств
                                    </a>
                                    
                                    <!-- start:row -->
                                    <div class="row">

                                        <? $posts = new WP_Query(array('posts_per_page' => 3, 'post_type' => 'visit'));

                                        if($posts->have_posts()):
                                            while($posts->have_posts()){
                                                $posts->the_post();
                                                ?>   

                                        <!-- start:col -->
                                        <div class="col-xs-4">
                                            <!-- start:article.linkbox -->
                                            <article>                                        
                                                <h3><a href="<? the_permalink()?>"><? the_title()?></a></h3>                                               
                                                <a href="<? the_permalink()?>">
                                                    <span class="text">
                                                       <? the_post_thumbnail('medium','class=img-responsive' );?>
                                                    </span>                                                                                    
                                                </a>
                                            </article>
                                            <!-- end:article.linkbox -->
                                            
                                        </div>
                                        <!-- end:col -->   
                                        <? } endif;?>                               
                                        
                                    </div>
                                    <!-- end:row -->
                                </section>
                                <!-- end:business-news -->     
                                <!-- start:row -->
                                <div class="row top-margin">
                                    <!-- start:col -->
                                    <div class="col-sm-6">
                                        
                                        <!-- start:showtime -->
                                        <section class="section-lifestyle news-layout">
                                            
                                            <header>
                                                <h2><a href="#">ФЕСТИВАЛИ</a></h2>
                                                <span class="borderline"></span>
                                            </header>
                                            <?  

                                            $args = array('posts_per_page' => 4, 'cat' => 5);

                                            if($today_post_category->term_id == $args['cat'])
                                            {
                                                $args['offset'] = 1;
                                            }

                                            $posts = new WP_Query($args);
                                            
                                            if($posts->have_posts()):
                                            while($posts->have_posts())
                                            { $posts->the_post();
                                                $url = CUtil::thumbUrl();?>
                                            <!-- start:article -->
                                            <article  class="clearfix fixed-layout-news">
                                                <h3><a href="<? the_permalink()?>"><? the_title()?></a></h3>
                                                <a style="background: url(<?=$url?>) no-repeat;" href="<? the_permalink()?>"></a>
                                                <span class="text fixed-layout"><?=strip_tags(CUtil::titleCut($post->post_content, 130))?></span>                                               
                                            </article>
                                            <!-- end:article -->                                               
                                            <?}?>
                                            <? endif?>   
                                            
                                        </section>
                                        <!-- end:showtime -->
                                            
                                    </div>
                                    <!-- end:col -->
                                    <!-- start:col -->
                                    <div class="col-sm-6">                                    
                                        
                                        <!-- start:showtime -->
                                        <section class="section-lifestyle news-layout">
                                            
                                            <header>
                                                <h2><a href="#">АГЕНТСТВА</a></h2>
                                                <span class="borderline"></span>
                                            </header>                                            
                                                                    
                                            <? $args = array('posts_per_page' => 4, 'cat' => 7);

                                            if($today_post_category->term_id == $args['cat'])
                                            {
                                                $args['offset'] = 1;
                                            }

                                            $posts = new WP_Query($args);
                                            
                                            if($posts->have_posts()):
                                            while($posts->have_posts())
                                            { $posts->the_post();
                                                $url = CUtil::thumbUrl();?>
                                            <!-- start:article -->
                                            <article class="clearfix fixed-layout-news">
                                                <h3><a href="<? the_permalink()?>"><? the_title()?></a></h3>
                                                <a style="background: url(<?=$url?>) no-repeat;" href="<? the_permalink()?>"></a>
                                                <span class="text fixed-layout"><?=strip_tags(CUtil::titleCut($post->post_content, 130))?></span>                                                
                                            </article>
                                            <!-- end:article -->                                               
                                            <?}?>
                                            <? endif?>   
                                        </section>
                                        <!-- end:showtime -->
                                        
                                    </div>
                                    <!-- end:col -->
                                </div>
                                <!-- end:row --> 
                                
                                
                            </div>
                            <!-- end:col -->
                            
                            <!-- start:col -->
                            <div class="col-md-3">
                                
                                <!-- start:latest-news -->
                                <section class="section-news news-layout daily-news">
                                    <!-- start:header -->
                                    <header>
                                        <h2><a href="#">Новости дня</a></h2>
                                        <span class="borderline"></span>
                                    </header>
                                    <!-- end:header -->
                                    
                                    <!-- start:row -->
                                    <div class="row">                                     
                                        <? $posts = new WP_Query(array('posts_per_page' => 8, 'cat' => -3, 'offset' => 1));
                                        if($posts->have_posts()):
                                        while($posts->have_posts())
                                        { $posts->the_post();?>
                                        <!-- start:col -->
                                        <div class="col-xs-4 col-sm-12">
                                            <!-- start:article -->
                                            <article>                                        
                                                <h3><a href="<? the_permalink()?>"><? the_title()?></a></h3>
                                                <span class="text"><?=strip_tags(CUtil::titleCut($post->post_content, 150))?></span>                                                                                    
                                                <span class="published"><?=get_the_date('d.m.Y', $post->ID)?></span>
                                            </article>
                                            <!-- end:article -->
                                        </div>
                                        <!-- end:col -->
                                        <?}?>
                                    <? endif?>
                                    </div>
                                    <!-- end:row -->
                                </section>
                                <!-- end:latest-news -->      

                                 <!-- start:Тендера -->
                                 <?/*
                                <section class="section-news news-layout">
                                    <!-- start:header -->
                                    <header>
                                        <h2><a href="#">Тендера</a></h2>
                                        <span class="borderline"></span>
                                    </header>
                                    <!-- end:header -->
                                    
                                   <!-- start:row -->
                                    <div class="row">                                     
                                        <? $$args = array('posts_per_page' => 2, 'cat' => 6);

                                            if($today_post_category->term_id == $args['cat'])
                                            {
                                                $args['offset'] = 1;
                                            }

                                            $posts = new WP_Query($args);
                                            
                                            if($posts->have_posts()):
                                        while($posts->have_posts())
                                        { $posts->the_post();?>
                                        <!-- start:col -->
                                        <div class="col-xs-4 col-sm-12">
                                            <!-- start:article -->
                                            <article>                                        
                                                <h3><a href="<? the_permalink()?>"><? the_title()?></a></h3>
                                                <span class="text"><?=strip_tags(CUtil::titleCut($post->post_content, 120))?></span>                                                                                    
                                                <span class="published"><?=get_the_date('d.m.Y', $post->ID)?></span>
                                            </article>
                                            <!-- end:article -->
                                        </div>
                                        <!-- end:col -->
                                        <?}?>
                                    <? endif?>
                                    </div>
                                    <!-- end:row -->
                                </section>
                                */?>
                                <!-- end:Тендера -->      

                                <? $attach = get_post(get_option('main_page_long_banner'));
                                if($attach->post_content != ''){?>
                                    <div class="ad">
                                        <a href="<?=$attach->post_content?>"><img src="<?=$attach->guid?>" width="160" height="auto" title="<?=$attach->title?>" /></a>
                                    </div>   
                                  
                                <?}else{?>  
                                    <div class="ad">
                                        <img src="<?=$attach->guid?>" width="160" height="auto" title="<?=$attach->title?>" />
                                    </div>                                       
                                <?}?>  

                                <!-- start:latest-news -->
                                <section class="section-news news-layout">
                                    <!-- start:header -->
                                    <header>
                                        <h2><a>Последние комментарии</a></h2>
                                        <span class="borderline"></span>
                                    </header>
                                    <!-- end:header -->
                                    
                                    <!-- start:row -->
                                    <div class="row">                                     
                                        
                                      
                                       <? $args = array(
                                            'number' => 3
                                        );
                                        $comments = get_comments($args);

                                        foreach($comments as $comment) :

                                            $date = new DateTime($comment->comment_date);                                      

                                            $comment_post = get_post($comment->comment_post_ID);
                                            
                                            ?>

                                        <!-- start:col -->
                                        <div class="col-xs-4 col-sm-12">
                                            <!-- start:article -->
                                            <article>                                        
                                                <a href="<?=get_permalink($comment_post->ID)?>">
                                                <span class="text"><?=CUtil::titleCut($comment->comment_content, 60);?></span>         
                                                </a>                                                                           
                                                <span class="published"><?=$date->format('d.m.Y')?></span>
                                            </article>
                                            <!-- end:article -->
                                        </div>
                                        <!-- end:col -->
                                    <? endforeach?>
                                        

                                    </div>
                                    <!-- end:row -->
                                </section>
                                <!-- end:latest-news -->                                                      
                            </div>
                            <!-- end:col -->
                            
                        </div>
                        <!-- end:row -->
        
                        
                    </div>
                    <!-- end:main -->
                    
                    <? get_sidebar('main')?>

                </div>
                <!-- end:page content -->
            
            </div>
            <!-- end:container -->

<? get_footer();?>