<!-- footer:page footer -->
            <footer id="page-footer">
                
                <!-- start:container -->
                <div class="container">
                    <? wp_nav_menu( array('container_id' => 'foot-menu', 'container_class'=> 'hidden_xs','container' => 'nav', 'menu_class' => 'clearfix', 'theme_location' => "secondary" ) );?>                   
                    
                    <!-- start:row -->
                    <div class="about row">
                    
                        <!-- start:col -->
                        <div class="col-sm-12 col-md-3">
                            <h3><a href="#"><img src="<?=TPL?>/images/logo2.png" style="    width: 213px;        margin-top: 37px;" alt="Willad.ru" /></a></h3>                          
                        </div>
                        <!-- end:col -->
                        
                        <!-- start:col -->
                        <div class="col-sm-6 col-md-5">                        
                        	<br>
                            <h4>Общая информация:</h4>
                            <? wp_nav_menu(array('menu'=>'foot', 'container' => '') );?>                            
                        </div>
                        <!-- end:col -->
                        
                        <!-- start:col -->
                        <div class="col-sm-6 col-md-4 text-right">
                        
                        	<br>
                            <?
                                $soc_opts = Array(
                                    'fa-twitter',
                                    'fa-facebook-square',
                                    'fa-linkedin-square',
                                    'fa-google-plus-square',
                                    'fa-vimeo-square',
                                    'fa-youtube',
                                    'fa-vk'
                                );

                                foreach($soc_opts as $opt)
                                {
                                    $opt_value = get_option($opt);

                                    if($opt_value != '')
                                    {?>
                                        <a href="<?=$opt_value?>"><i class="fa <?=$opt?> fa-lg"></i></a>
                                    <?}
                                }
                            ?>      
                            <br>
                            <br>
                            <br>
                            <br>
                            <p class="created-by">Сделано в <a href="http://iqharvest.ru">IQ HARVEST</a></p>
                        </div>
                        <!-- end:col -->

                    </div>
                    <!-- end:row -->
                    
                    <!-- start:row -->
                    <div class="copyright row">
                    
                        <!-- start:col -->
                        <div class="col-sm-2">
                            &copy; <a href="/" style="letter-spacing:0.05em">Willad</a> <?=date('Y')?>
                        </div>
                        <!-- end:col -->

                        <!-- start:col -->
                        <div class="col-sm-6 text-center" style="text-align:center">
                            Использование материалов Willad.ru допустимо только с указанием источника.
                        </div>
                        <!-- end:col -->
                        
                        <!-- start:col -->
                        <div class="col-sm-4 text-right">
                            <span class="age_restrict">+18</span>
                            <?=get_option('counters')?>
                        </div>
                        <!-- end:col -->

                    </div>
                    <!-- end:row -->
                
                </div>
                <!-- end:container -->
        
            </footer>
            <!-- end:page footer -->
        
        </div>
        <!-- end:page inner wrap -->
    </div>
    <!-- end:page outer wrap -->
    
    
  <? wp_footer();?>
    
</body>
</html>