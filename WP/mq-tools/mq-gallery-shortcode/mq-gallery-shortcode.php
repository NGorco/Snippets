<?php

/*
* Plugin Name: Mq Gallery ShortCode
* Version: 1.0
* Description: Show some items
* Author: Massique
* Author URI: http://massique.com/

* WordPress -
* Requires at least: 4.1
* Tested up to: 4.1
*/

define('TPL', get_template_directory_uri());

class MqGalleryShortcode
{
	
	function __construct()
	{
		$this->init();
	}

	function init()
	{
		add_shortcode('mq-gallery', array($this, draw_gallery) );
		wp_enqueue_style('mq-anythinggallery-styles', plugin_dir_url(__FILE__) . '/assets/anythingslider.css');
		wp_enqueue_style('mq-slider-styles', plugin_dir_url(__FILE__) . '/assets/mq-slider-fix.css');
		wp_enqueue_script('mq-gallery-script-slider' ,plugin_dir_url(__FILE__) . '/assets/jquery.anythingslider.js',array( 'jquery' ));
		wp_enqueue_script('mqslider-class' ,plugin_dir_url(__FILE__) . '/assets/mqslider.js',array( 'jquery', 'mq-gallery-script-slider' ));
	}

	function draw_gallery()
	{
		$posts = get_posts(array(

			'post_type' => 'gallery',
			'posts_per_page' => 1000,
			'orderby' => 'page_order',
			'order' => 'asc'
		));

		$cnt = 0;
		$group_id = 0;
		$gallery_arr = Array();
		

		if(count($posts) > 0 )

		foreach($posts as $post)
		{
			if($cnt%8 == 0)
			{	
				$group_id++;
			}

			$gallery_arr[$group_id][] = $post;
			$cnt++;
		}


		$slider_id = mt_rand();

		$out = '<div class="mq-gallery"><h2 class="cHeader"><span class="cHeader-text">Галерея работ</span></h2><div class="mqslider-container"><div class="controls"><div class="slide slide-left"></div><div class="slide slide-right"></div></div><ul id="mqslider_' . $slider_id . '" class="mqslider">';

		foreach ($gallery_arr as $item) {
			
			$out .= "<li>";

			foreach ($item as $inner_item) {

				$url = wp_get_attachment_url( get_post_thumbnail_id($inner_item->ID) , 'full' );
				
				$out .= "<div class='item_wrap'><div class='gallery_text'><p class='item_header'>" . $inner_item->post_title . "</p><p class='item_text'>" . $inner_item->post_excerpt . "</p></div><div class='item_preview'><div style='background-image: url(". $url .")'></div></div>";
				$out .= "<div class='item_pictures'>" . $inner_item->post_content . "</div></div>";
			}

			$out .= "</li>";
		}


		$out .= '</ul>
		</div><script>
		jQuery(function($){
			var slider = $("#mqslider_' . $slider_id . '").mqSlider();			
		});</script></div>';
		
		return $out;
	}
}

if(!is_admin())
{
	new MqGalleryShortcode();
}
?>