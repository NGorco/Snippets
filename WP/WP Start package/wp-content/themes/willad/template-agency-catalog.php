<? 
/*
* Template name: Agencies Catalog
*/
get_header();

$cat_id = '';

global $wp_query;

if(isset($_GET['agency_name'])) $_SESSION['agency_title_filter'] = $_GET['agency_name'];
if(isset($_GET['agency_client'])) $_SESSION['agency_client_filter'] = $_GET['agency_client'];

if(!isset($_SESSION['agency_title_filter'])) $_SESSION['agency_title_filter'] = '';
if(!isset($_SESSION['agency_client_filter'])) $_SESSION['agency_client_filter'] = '';

$args = Array('post_type' => 'agency', 'orderby' => 'post_date', 'order' => 'desc', 'meta_query' => Array());

if(!empty($_SESSION['agency_client_filter'])) $args['meta_query'][] = Array('key' => 'clients', 'compare' => 'LIKE', 'value' => ($_SESSION['agency_client_filter']));
if(!empty($_SESSION['agency_title_filter'])) $args['s'] = $_SESSION['agency_title_filter'];

$agencies_query = new WP_Query($args);


$the_term = $wp_query->queried_object;
?>

<!-- start:container -->
            <div class="container">
                
                <!-- start:page content --> 
                <div id="page-content" class="clearfix">
                    
                    <!-- start:main -->
                    <div id="main" class="article">
                        
                        <article id="article-post" class="cat-sports">
                            
                            <header>
                                <? CUtil::breadcrumb()?>
                                
                                <h1>Каталог агентств</h1>
                            </header>                            

                            <section id="agencies-catalog" class="module-timeline">
                                <form action="#" class="form-inline agencies-filter-form">
                                    <div class="form-group">
                                        <label for="_id-agencies-catalog-form--agency-name" class="sr-only">Название агентства</label>
                                        <input type="text" value="<?=($_SESSION['agency_title_filter'] ? $_SESSION['agency_title_filter'] : '')?>" name="agency_name" id="_id-agencies-catalog-form--agency-name" class="form-control" placeholder="Название агентства">
                                    </div>
                                    <div class="form-group">
                                        <label for="_id-agencies-catalog-form--agency-client" class="sr-only">Клиент</label>
                                        <input type="text" value="<?=(isset($_GET['agency_client']) ? $_GET['agency_client'] : '')?>" name="agency_client" id="_id-agencies-catalog-form--agency-client" class="form-control" placeholder="Клиент">
                                    </div>
                                    <div class="form-actions">
                                        <span class="icon"><span class="fa fa-search"></span></span>
                                        <button type="submit" class="btn btn-default">Поиск</button>
                                    </div>
                                </form>
                                <ul class="agencies-cats">                             
                                    <? 
                                        $terms = get_terms('agency_type', Array('parent'=> 0));?>
                                        <? foreach($terms as $child_term){?>
                                            <li>
                                                <a class="btn btn-default" href="<?=get_term_link(IntVal($child_term->term_id), 'agency_type')?>">
                                                    <?=$child_term->name?>
                                                </a>
                                            </li>
                                        <?}?>                           
                                </ul>                              
                                <div class="results-header">
                                    По вашему запросу найдено агентств:  <?=$agencies_query->post_count?>                 
                                </div>
                                <div class="articles">
                                    <? if(have_posts()):?>
                                        <? while($agencies_query->have_posts()):$agencies_query->the_post(); $cat_id = $post->post_category[0];?>
                                <!-- start:article-post -->
                                    <article>
                                        <a class="article-preview" href="<?=get_post_permalink($post->ID)?>"><?=the_post_thumbnail($post->ID, 'thumbnail','class=wp-post-image');?></a>
                                        <div class="cnt">
                                            <i class="bullet bullet-showtime"></i>                                        
                                            <h3><a href="<?=get_post_permalink($post->ID)?>"><? the_title()?></a> <small>маркетинговые услуги</small></h3>
                                            <span class="text">
                                                <p>
                                                    <strong>АДРЕС</strong>: <?=get("address")?><br>
                                                    <? preg_match("/http/",get('site'), $matches);?>
                                                    <strong>САЙТ</strong>: <a href="<?=(count($matches) > 0) ? get('site') : "http://" . get('site')?>"><?=get('site')?></a><br>
                                                    <strong>УСЛУГИ</strong>: <?=get('services')?>
                                                </p>
                                            </span>
                                        </div>                                
                                    </article>
                                <? endwhile; endif;?>
                                    
                                </div> 
                            </section>                       
                        </article>
                                     
                    </div>
                    <!-- end:main -->
                    
                     <? get_sidebar('single')?>

                </div>
                <!-- end:page content -->
            
            </div>
            <!-- end:container -->

<? get_footer()?>