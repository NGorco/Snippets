<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
	<?php if ( have_comments() ) : ?>	
		<header>
            <h2><a href=""> <? 
            	printf( _nx( 'Один комментарий', '%1$s комментария', get_comments_number(), 'comments title', 'twentyfifteen' ),
					number_format_i18n( get_comments_number() ), get_the_title() );
            ?></a></h2>
            <span class="borderline"></span>
        </header>	
		<ol id="comments-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ul',
					'short_ping'  => true,
					'avatar_size' => 75,
					'callback' => "CUtil::willad_comment"
				) );
			?>
		</ol><!-- .comment-list -->

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfifteen' ); ?></p>
	<?php endif; ?>
	 <!-- start:article-comments-form -->
                        <section id="article-comments-form">
                                          
                            <header>
                                <h2><a >Оставить комментарий</a></h2>
                                <span class="borderline"></span>
                            </header>
                        
                            <!-- start:form -->
                            <form action="/wp-comments-post.php" method="post" role='form' id="commentform" class="comment-form">                    		

                                <!-- start:row -->
                                <div class="row bottom-margin">
                                    
                                    
                                    <!-- start:col -->
                                    <div class="col-sm-5">

                                        <? if(is_user_logged_in()){
                                            $user = wp_get_current_user();
                                            ?>
                                            <p class="logged-in-as">Вы вошли как <a href="<?=$_SERVER['SERVER_NAME'].'/user?cabinet'?>"><strong><?=$user->data->display_name?></a></strong></p>                                            
                                            <br>
                                        <?}else{?>

                                        	<input class="form-control" id="author" name="author" value="" size="30" aria-required="true"  placeholder="Имя" required="required" type="text">
                                            <input id="email" style="display:none" class="form-control" name="email" value="default@willad.ru" size="30" aria-describedby="email-notes" aria-required="true"  placeholder="E-mail" required="required" type="text"><br>          
                                        <?}?>
                                        <div class="g-recaptcha"  data-sitekey="6LfXIQ4TAAAAADJXF5vK8X3OT3gXM7slI45nFLS4"></div> 
                                        <? if(is_user_logged_in()){?>
                                            <input style="top:20px;" type="submit" class="show-more cat-<?=CUtil::cat_color($cat_id)?>" value="Оставить комментарий" />
                                        <?}else{?>
                                            <input type="submit" class="show-more cat-<?=CUtil::cat_color($cat_id)?>" value="Оставить комментарий" />
                                        <?}?>
                                    </div>
                                    <!-- end:col -->        

                                    <!-- start:col -->
                                    <div class="col-sm-7">
                                       
                                        <textarea id="comment" class="form-control" name="comment" cols="45" rows="6" aria-required="true" required="required" placeholder="Ваш комментарий"></textarea>
                                    </div>
                                    <!-- end:col -->    
                                </div>
                                <!-- end:row -->
                                
                                <p class="reply-to-label">
                                <span class="reply-to-who"></span>.
                                    <span class="cancel_reply">Отменить ответ?</span>
                                </p>

                                <!-- start:row -->
                                <div class="row bottom-margin">
                                    
                                    <!-- start:col -->
                                    
                                    <!-- end:col -->

                                </div>
                                <!-- end:row -->
                                
                                <!-- start:load-more -->
                                <div>                                   
                                    <input type="hidden" name="comment_post_ID" value="<?=$post->ID?>" id="comment_post_ID">
                                    <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                                </div>
                                <!-- end:load-more -->
                            
                            </form>
                            <!-- end:form -->
                            

                        </section>
                        <!-- end:article-comments-form -->          
	<?php /*comment_form( array('')); */?>

