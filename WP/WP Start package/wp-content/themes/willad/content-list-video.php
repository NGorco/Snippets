<?php
/**
 * The template for displaying posts in the Video post format
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			echo apply_filters('the_content', $post->post_excerpt);
		
		?>
	</div><!-- .entry-content -->
	
</article><!-- #post -->
