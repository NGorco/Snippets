<?
// Template name: Contacts
 get_header();
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
                           
                            <header>
                            	<? CUtil::breadcrumb()?>
                                
                                <h1><? the_title()?></h1>
                            </header>   
                            
                            <? $address = simple_fields_value('map_addrr');
                            if($address !='')
                            {
                                mq_custom_map($address);
                                ?><br><?
                            }
                            ?>

                            <? the_content();?>

                             <!-- start:info-box -->
                            <div class="info-box">
                                
                                <p class="icon-padding"><i class="fa fa-map-marker"></i> <strong><?=get_option('blogname')?> </strong><br />
                                <?=simple_fields_value('map_addrr')?></p>
                                
                                <p class="icon-padding"><i class="fa fa-phone"></i> Телефон: <?=simple_fields_value('phone_num')?> <br />
                                </p>
                                
                                <p class="icon-padding"><i class="fa fa-envelope"></i> Email: <a href="mailto:<?=simple_fields_value('email')?>"><?=simple_fields_value('email')?></a><br />
                                Сайт: <a href="/"><?=$_SERVER['SERVER_NAME']?></a></p>
                                
                            </div>
                            <!-- end:info-box -->

                            <!-- start:form section -->
                            <section>
                                
                                <header>
                                    <h2>Форма обратной связи</h2>
                                    <span class="borderline"></span>
                                </header>

                                <!-- start:form -->
                                <form role="form" id="contactForm" handy-form action="contactFormFeedback" method="get">
                            
                                    <!-- start:form alerts -->
                                    <div class="alert alert-danger hide" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                        <h4>Ошибка при отправке письма!</h4>
                                        <p>Попробуйте отправить письмо снова.</p>
                                    </div>
                                    
                                    <div class="alert alert-success hide" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                        <h4>Письмо удачно отправлено!</h4>
                                        <p>Мы скоро вам ответим.</p>
                                    </div>
                                    <!-- end:form alerts -->
                                    <div class="form-container">
                                    <!-- start:row -->
                                    <div class="row bottom-margin">
                                        
                                        <!-- start:col -->
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="Имя" id="fname" name="fname" required>
                                        </div>
                                        <!-- end:col -->
                                        
                                        <!-- start:col -->
                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" placeholder="E-mail адрес" id="email" name="email" required>
                                        </div>
                                        <!-- end:col -->
                                    
                                    </div>
                                    <!-- end:row -->
                                    
                                    <!-- start:row -->
                                    <div class="row bottom-margin">
                                        
                                        <!-- start:col -->
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="Фамилия" id="lname" name="lname" required>
                                        </div>
                                        <!-- end:col -->
                                        
                                        <!-- start:col -->
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="Телефон" id="phone" name="phone" required>
                                        </div>
                                        <!-- end:col -->
                                    
                                    </div>
                                    <!-- end:row -->
                                    
                                    <!-- start:row -->
                                    <div class="row bottom-margin">
                                        
                                        <!-- start:col -->
                                        <div class="col-md-12">
                                            <textarea class="form-control" placeholder="Сообщение" rows="5" id="message" name="message" required></textarea>
                                        </div>
                                        <!-- end:col -->
    
                                    </div>
                                    <!-- end:row -->
                                    
                                    <!-- start:load-more -->
                                    <div>
                                        <input type="submit" value="Отправить письмо" class="show-more">
                                    </div>
                                    <!-- end:load-more -->
                                    </div>
                            
                                </form>
                                <!-- end:form -->
                            
                            </section>
                            <!-- end:form section -->

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