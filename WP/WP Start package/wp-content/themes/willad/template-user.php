<?
/*
* Template name: User
*/
if(isset($_GET['cabinet']) || isset($_GET['cabinet-edit']))
{
	if(!is_user_logged_in()) {
		header("Location: /user?register");
		die();
	}
}

get_header();?>

<!-- start:container -->
            <div class="container">
                
                <!-- start:page content -->
                <div id="page-content" class="clearfix">
                    
                    <!-- start:main -->
                    <div id="main" class="article">
                        
                        <!-- start:article-post -->
                        <article id="article-post" class="cat-sports">
                            
                            <div class="head-image thumb-wrap relative">
                                <? the_post_thumbnail("full", "class=img-responsive" );?>
                                <a href="#" class="theme">
                                </a>
                            </div>                            
                            
							<? if(isset($_GET['login']))
							{
								include('includes/user-templates/login.php');
							}?>

                            <? if(isset($_GET['register']))
							{
								include('includes/user-templates/register.php');
							}?>

                            <? if(isset($_GET['end-register-1']))
							{
								include('includes/user-templates/register-step-1.php');
							}?>

                            <? if(isset($_GET['end-register-2']))
							{
								include('includes/user-templates/register-step-2.php');
							}?>

							<? if(isset($_GET['pass-recover']))
							{
								include('includes/user-templates/pass-recover.php');
							}?>

							<? if(isset($_GET['cabinet']))
							{								
								include('includes/user-templates/cabinet.php');
							}?>

							<? if(isset($_GET['cabinet-edit']))
							{
								include('includes/user-templates/cabinet-edit.php');
							}?>
                            
						  
                        </article>
                        <!-- end:article-post -->
                        
                    </div>
                    <!-- end:main -->
                    
	                 <?// get_sidebar('category')?>    
                </div>
                <!-- end:page content -->
            
            </div>
            <!-- end:container -->


<? get_footer();?>