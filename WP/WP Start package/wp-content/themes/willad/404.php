<? 
get_header();
?>
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
                                	404 ошибка
                                	</div>
                                </h2>
                                <span class="borderline"></span>
                            </header>
                            
                            <!-- start:articles -->
                          
                            <div class="articles">                          
                                    <h5>
                                        Эта страница, к сожалению, пуста. 
                                    </h5> 
                            </div>
                            <!-- end:articles -->                            
                            
							<? /* AJAX pagination

							<div id="temporary-ajax"></div>
							*/?>
                        </section>
                        <!-- end:archive-page -->                  
					
                    </div>
                    <!-- end:main -->
                    
                    <? get_sidebar('category')?>

                </div>
                <!-- end:page content -->
            
            </div>
            <!-- end:container -->

<? get_footer()?>