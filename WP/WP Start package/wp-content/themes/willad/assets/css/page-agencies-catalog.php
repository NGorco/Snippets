<? 
/*
* Template name: Agencies Catalog
*/
get_header();

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
                            <? if($cat->term_id != 3){?>
                            <div class="head-image thumb-wrap relative">
                                <? the_post_thumbnail("full", "class=img-responsive" );?>
                                <a href="#" class="theme">
                                </a>
                            </div>
                            <?}?>
                            <header>
                            	<? CUtil::breadcrumb()?>
                                
                                <h1><? the_title()?></h1>
                            </header>                            

    	                    <section id="agencies-catalog" class="module-timeline">
                                <form action="#" class="form-inline agencies-filter-form">
                                    <div class="form-group">
                                        <label for="_id-agencies-catalog-form--agency-name" class="sr-only">Название агентства</label>
                                        <input type="text" name="agencies-catalog-form--agency-name" id="_id-agencies-catalog-form--agency-name" class="form-control" placeholder="Название агентства">
                                    </div>
                                    <div class="form-group">
                                        <label for="_id-agencies-catalog-form--agency-client" class="sr-only">Клиент</label>
                                        <input type="text" name="agencies-catalog-form--agency-client" id="_id-agencies-catalog-form--agency-client" class="form-control" placeholder="Клиент">
                                    </div>
                                    <div class="form-actions">
                                        <span class="icon"><span class="fa fa-search"></span></span>
                                        <button type="submit" class="btn">Поиск</button>
                                    </div>
                                </form>
                                <ul class="agencies-cats">
                                    <li><a href="#">Рекламные агентства</a></li>
                                    <li><a href="#">Digital-агентства</a></li>
                                    <li><a href="#">Медиапровайдеры</a></li>
                                    <li><a href="#">Производство рекламы</a></li>
                                </ul>
                                <div class="input-append date" id="archive-date-picker" data-date="02.11.2015" data-date-format="dd.mm.yyyy">
                                    <input class="span2" size="16" type="text" value="02.11.2015" readonly="">                        
                                </div>
                                <div class="articles">
                                    <article>
                                        <a class="article-preview" href="#"><img width="100" height="100" src="http://willad.ru/wp-content/uploads/2015/11/image-01.jpg" class="wp-post-image" alt="sig5"></a>
                                        <div class="cnt">
                                            <i class="bullet bullet-showtime"></i>                                        
                                            <h3><a href="#">Louder</a> <small>маркетинговые услуги</small></h3>
                                            <span class="text">
                                                <p>
                                                    АДРЕС: Россия, Москва<br>
                                                    САЙТ: http://www.louder.ru<br>
                                                    УСЛУГИ: BTL, Digital, Event, louder® - прогрессивная команда агентства маркетинговых коммуникаций, основанного в Москве в 2007 году. Реализует интегрированные проекты для локальных и международных брендов, разрабатывая креативные решения на основе нестандартных подходов и передовых технологий.
                                                    С 2015 года входит в составмеждународной рекламной группы Serviceplan Group (31 агентство в 27 городах мира, более 2300 сотрудников). Сегодня является частью российской группы Serviceplan Russia, представленной в Москве двумя агентствами: Serviceplan и Louder.
                                                </p>
                                            </span>
                                        </div>                                
                                    </article>
                                    <article>
                                        <a class="article-preview" href="#"><img width="100" height="100" src="http://willad.ru/wp-content/uploads/2015/11/image-02.jpg" class="wp-post-image" alt="sig5"></a>
                                        <div class="cnt">
                                            <i class="bullet bullet-showtime"></i>                                        
                                            <h3><a href="#">JAMI</a> <small>digital</small></h3>
                                            <span class="text">
                                                <p>
                                                    АДРЕС: Россия, Москва<br>
                                                    САЙТ: http://www.louder.ru<br>
                                                    УСЛУГИ: BTL, Digital, Event, louder® - прогрессивная команда агентства маркетинговых коммуникаций, основанного в Москве в 2007 году. Реализует интегрированные проекты для локальных и международных брендов, разрабатывая креативные решения на основе нестандартных подходов и передовых технологий.
                                                    С 2015 года входит в составмеждународной рекламной группы Serviceplan Group (31 агентство в 27 городах мира, более 2300 сотрудников). Сегодня является частью российской группы Serviceplan Russia, представленной в Москве двумя агентствами: Serviceplan и Louder.
                                                </p>
                                            </span>
                                        </div>                                
                                    </article>
                                    <article>
                                        <a class="article-preview" href="#"><img width="100" height="115" src="http://willad.ru/wp-content/uploads/2015/11/image-03.jpg" class="wp-post-image" alt="sig5"></a>
                                        <div class="cnt">
                                            <i class="bullet bullet-showtime"></i>                                        
                                            <h3><a href="#">Instinct</a> <small>маркетинговые услуги</small></h3>
                                            <span class="text">
                                                <p>
                                                    АДРЕС: Россия, Москва<br>
                                                    САЙТ: http://www.louder.ru<br>
                                                    УСЛУГИ: BTL, Digital, Event, louder® - прогрессивная команда агентства маркетинговых коммуникаций, основанного в Москве в 2007 году. Реализует интегрированные проекты для локальных и международных брендов, разрабатывая креативные решения на основе нестандартных подходов и передовых технологий.
                                                    С 2015 года входит в составмеждународной рекламной группы Serviceplan Group (31 агентство в 27 городах мира, более 2300 сотрудников). Сегодня является частью российской группы Serviceplan Russia, представленной в Москве двумя агентствами: Serviceplan и Louder.
                                                </p>
                                            </span>
                                        </div>                                
                                    </article>
                                </div> 
                            </section>                       
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