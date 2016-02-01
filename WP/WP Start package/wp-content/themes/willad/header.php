<!doctype html >
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en-US"> <!--<![endif]-->
<head>
    <!-- start:global -->
    <meta charset="utf-8">
    <!-- end:global -->

    <!-- start:page title -->
    <title><?=wp_title()?> </title>
    <!-- end:page title -->  
    <script>location.hash = ''</script>
    <? wp_head()?>
    <link rel="icon favicon" href="<?=TPL?>/images/wlogo1-1.png">
    <!-- start:responsive web design -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- end:responsive web design -->
    
    <!-- start:web fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,500italic,400italic,700,700italic%7CRoboto+Condensed:400,700%7CRoboto+Slab' rel='stylesheet' type='text/css'>
    <!-- end:web fonts -->   

    <!--[if lte IE 8]>
    <script src="<?=TPL?>/assets/js/respond.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="<?=TPL?>/assets/css/photobox.ie.css">
    <script src="<?=TPL?>/assets/js/html5shiv.js"></script>
    <![endif]-->
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "f0932cd2-1a2f-4703-bcb4-9548227c711e", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
    <script>var Data = {}</script>
</head>
<body>
    
    <!-- start:page outer wrap -->
    <div id="page-outer-wrap">
        <!-- start:page inner wrap -->
        <div id="page-inner-wrap">        
            
            <!-- start:page header mobile -->
            <header id="page-header-mobile" class="visible-xs">
                
                <!-- start:sidr -->
                <div id="sidr">
                    <form id="search-form-mobile" action="/">
                        <input type="text" name="s" id="qsearch" placeholder="Поиск по сайту" />
                    </form>
                    <ul>
                    	 <? wp_nav_menu( array(
                                    'container' => '', 
                                    'menu_class' => 'nav clearfix', 
                                    'theme_location' => "main" ,
                                    'items_wrap'      => '%3$s',
                                    ) );?> 
                    </ul>
                    
                </div>
                <!-- end:sidr -->
                
                <!-- start:row -->
                <div class="row">
                    
                    <!-- start:col -->
                    <div class="col-xs-6">
                        <!-- start:logo -->
                        <h1><a href="/"><img src="<?=TPL?>/images/wlogo1.png" alt="Weekly News" width="147" /></a></h1>
                        <!-- end:logo -->
                    </div>
                    <!-- end:col -->
                    
                    <!-- start:col -->
                    <div class="col-xs-6 text-right">
                        <a id="nav-expander" href=""><span class="glyphicon glyphicon-th"></span></a>
                    </div>
                    <!-- end:col -->
                    
                </div>
                <!-- end:row -->
                
            </header>
            <!-- end:page header mobile -->
            
            <!-- start:page header -->
            <header id="page-header" class="hidden-xs">
                
                <!-- start:header-branding -->
                <div id="header-branding">
                
                    <!-- start:container -->
                    <div class="container">
                        
                        <!-- start:row -->
                        <div class="row">
                        
                            <!-- start:col -->
                            <div class="col-sm-6 col-md-7">
                                <!-- start:logo -->
                                <h1>
                                	<a href="/"><img src="<?=TPL?>/images/logo-white.png" alt="Weekly News" /></a>
									<a id="logo-dog" href="/"><img src="<?=TPL?>/images/wlogo1-1.png" alt="Weekly News" /></a>
                                </h1>
                                <!-- end:logo -->
                            </div>
                            <!-- end:col -->
                            
                            <!-- start:col -->
                            <div class="col-sm-6 col-md-5 text-center">
                                
                                <form id="search-form" action="/">
                                    <input type="text" name="s" id="qsearch" placeholder="Поиск по сайту" />
                                    <button><span class="glyphicon glyphicon-search"></span></button>
                                </form>
                                
                            </div>
                            <!-- end:col -->                          
                          
                        
                        </div>
                        <!-- end:row -->
    
                    </div>
                    <!-- end:container -->
                    
                 </div>
                <!-- end:header-branding -->
                
                <!-- start:header-navigation -->
                <div id="header-navigation">
                
                    <!-- start:container -->
                    <div class="container">
                        <div id="menu">
                            <ul id="menu-main" class="nav clearfix">
                                <!-- start:menu -->
                                <? wp_nav_menu( array(
                                    'container' => '', 
                                    'menu_class' => 'nav clearfix', 
                                    'theme_location' => "main" ,
                                    'items_wrap'      => '%3$s',
                                    ) );?>                      
                                <!-- end:menu -->
                                <li class="options">
                                    <? if(!is_user_logged_in()){?>
                                    <a href="/user?login">
                                    <span class="glyphicon glyphicon-asterisk"></span> Войти</a> | 
                                    <a href="/user?register">
                                        <span class="glyphicon glyphicon-pencil"></span> Зарегистрироваться
                                    </a>
                                    <?}else{?>
                                    <a href="/user?cabinet">Личный кабинет</a>
                                    <a href="#" onclick="Handy.logout()">Выйти</a>
                                    <?}?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end:container -->
                    
                </div>
                <!-- end:header-navigation -->                
  
            </header>
            <!-- end:page header -->