<? 

/*
* Template name: Calendar
*/
get_header();
?>
<!-- start:container -->
 <!-- Long live the font Ubuntu ! -->       
            <div class="container">
                
                <!-- start:page content -->
                <div id="page-content" class="clearfix">
                    
                    <!-- start:main -->
                    <div id="main" class="article">
                        
                        <!-- start:article-comments -->
                        <section id="archive-page" class="module-timeline">
                                        
                            <header>
                                <h2>
                                    <a class="add-event" onclick="jQuery('.event-add').slideToggle()">+ Добавить событие </a>
                                    <div class="cat-<?=$cat_color?>-header category-header">
                                    Календарь событий
                                    </div>
                                </h2>

                                <span class="borderline"></span>
                            </header>

                            <!-- start:calendar-event-add-form -->
                            <div class="event-add" style="display:none;">
                                <form action="addCalendarEvent" handy-form>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-6">
                                            <input type="text" required name="post_title" style="width:100%" placeholder="Название события">
                                        </div>

                                        <div class="col-md-6 col-xs-6">
                                            <input type="date" required name="meta[event_date]" style="width:100%" placeholder="Дата события">
                                        </div>
                                    </div>

                                    <textarea name="post_content" id="" style="width:100%" rows="10" placeholder="Описание события"></textarea>
                                    <div class="row">
                                         <div class="col-md-6 col-xs-6">
                                            <input type="submit" style="width:100%" value="Добавить событие">
                                         </div>
                                         <div class="col-md-6 col-xs-6">
                                            <? $options = get_categories();?>
                                            <select style="width:100%" name="post_category">
                                                <? foreach($options as $option){?>
                                                    <option value="<?=$option->term_id?>"><?=$option->name?></option>
                                                <?}?>
                                            </select>
                                         </div>
                                    </div>
                                    
                                    <input type="hidden" name="post_type" value="events">
                                </form>
                            </div>
                            <!-- end:calendar-event-add-form -->
                            
                            <!-- start:articles -->
                          
                            <div class="articles">                          
                                   <div id="calendari_lateral1"></div>
                            </div>                         
                            <!-- end:articles -->                            
                            
							<? /* AJAX pagination

							<div id="temporary-ajax"></div>
							*/?>
                        </section>
                        <!-- end:archive-page -->                  
					
                    </div>
                    <!-- end:main -->
                    
                    <? get_sidebar('calendar')?>

                </div>
                <!-- end:page content -->
            
            </div>
            <!-- end:container -->
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,700' rel='stylesheet' type='text/css'>
    <?
    wp_enqueue_script('bic-calendar', TPL . '/assets/js/bic_calendar.js', array('jquery') );
    wp_enqueue_script('calendar-script', TPL . '/assets/js/template-calendar.js', array('jquery') );
    wp_enqueue_style('bic-calendar', TPL . '/assets/css/bic_calendar.css' );
    ?>

        <script src="https://rawgithub.com/moment/moment/develop/min/moment-with-langs.min.js"></script>
<? get_footer()?>