<?php

/**
* Util class
*/
class CUtil
{
	public static $callbacks = Array();

	static function get_meta($meta_code, $ID = '')
	{
		global $post;

		return array_shift(get_post_meta(is_numeric($ID) ? $ID : $post->ID,  $meta_code));
	}	

	static function titleCut($str,$len=1000){

		if(strlen($str)>$len){
			return mb_substr ($str,0,$len,"UTF-8")."...";
		}else{
			return $str;
		}
	} 

	static function noindex_filter($content)
	{
		return preg_replace("/(<a.*?href=[\"\']?(?!.*willad)[\"\']?.*<\/a>)/ i", "<!--noindex-->$1<!--/noindex-->", $content);
	}

	static function thumbUrl($post_id = '', $size = 'thumbnail')
	{
		global $post;

		if($post_id == '')
		{
			$postId = $post->ID;
		}

		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size);

		return $thumb[0];
	}

	static function thumbDiv($post_id = '', $size = 'thumbnail', $height = '180', $class = '')
	{
		?><div class="<?=$class?>" style="height: <?=$height?>px; background: url(<?=CUtil::thumbUrl($post_id, $size)?>) no-repeat center center; background-size: cover"></div><?
	}

	static function curr_taxonomy()
	{
		if( is_tax() ) 
		{
		    global $wp_query;
		    $term = $wp_query->get_queried_object();

		    return get_taxonomy($term->taxonomy);
		}
	}

	static function saveUserData()
	{
		if(is_user_logged_in() && count($_POST['user']) > 0)
	    {
	        $user_id = get_current_user_id();
	        foreach ($_POST['user'] as $meta_key => $meta_value) 
	        {               
	            update_user_meta( $user_id, $meta_key, $meta_value );
	        }
	        
	        if(!empty($_FILES['avatar']))
	        {
	            $path = wp_upload_dir();
	            $path = $path['path'];

	          

	            $ext = array_pop(explode(".",$_FILES['avatar']['name']));

	            if($ext != '')
	            {		            
		            $rand = md5(mt_rand() . date('X'));
		            $filename = "avatar_" . $rand . "." . $ext;

		          

		            move_uploaded_file($_FILES['avatar']['tmp_name'], $path . "/" . $filename);
		            	
		            // The ID of the post this attachment is for.
		            $parent_post_id = 0;

		            // Check the type of file. We'll use this as the 'post_mime_type'.
		            $filetype = wp_check_filetype( basename( $filename ), null );


		            // Prepare an array of post data for the attachment.
		            $attachment = array(
		                'guid'           => wp_upload_dir()['url'] . "/" .  $filename, 
		                'post_mime_type' => $filetype['type'],
		                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
		                'post_content'   => '',
		                'post_status'    => 'inherit'
		            );

		            // Insert the attachment.
		            $attach_id = wp_insert_attachment( $attachment, wp_upload_dir()['url'] . "/" .  $filename, $parent_post_id );

		            // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
		            require_once( ABSPATH . 'wp-admin/includes/image.php' );

		            // Generate the metadata for the attachment, and update the database record.
		            $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		            wp_update_attachment_metadata( $attach_id, $attach_data );

		            update_user_meta( $user_id, 'avatar_id', $attach_id );
		        }
	        }
	        
	        FSSubscribeCore::saveSubscribes();
	    }
	}

	static function custom_wp_query($args = Array(), $template = '')
	{
		$out = array();

		if(!isset($args['posts_per_page']))
		{
			$args['posts_per_page'] = 1000;
		}

		$query = new WP_Query($args);
		$query_cnt = 0;

		if($query->have_posts())
		{		
			while($query->have_posts()) 
			{
				$query_cnt++;
				$query->the_post();

				if($template != '' && file_exists(__DIR__ . '/includes/loops/' . $template . '-loop.php'))
				{
					include(__DIR__ . '/includes/loops/' . $template . '-loop.php');
				}else{

					the_content();
				}
			}
		}
		
		$out['posts_count'] = $query_cnt;
		wp_reset_query();

		return $out;
	}

	static function show_post($attr)
	{
		if(empty($attr['additional_args'])) $attr['additional_args'] = Array();

		if(!$attr['id'] && isset($attr['template']) && $attr['template'] != '' && file_exists( __DIR__ . '/includes/' . $attr['template'] . '.php')){

			include( __DIR__ . '/includes/' . $attr['template'] . '.php');
		}else{

			$query = new WP_Query(array_merge(Array('p' => $attr['id'],"post_status" => 'publish', 'post_type'=>'any'), $attr['additional_args']));

			if($query->have_posts())
			{
				while($query->have_posts()): $query->the_post();

					if(isset($attr['template']) && $attr['template'] != '' && file_exists( __DIR__ . '/includes/' . $attr['template'] . '.php')){
						
						include( __DIR__ . '/includes/' . $attr['template'] . '.php');
					}else{
						the_content();
					}
				endwhile;
			}
		}
	}

	static function add_filter($hook, $callback, $priority = "", $accepted_args = Array())
	{	
		add_filter($hook, "clbk_" . mt_rand(0,10000000000), $priority, $accepted_args);
	}

	static function cat_color($cat_id)
	{	
		$cat_color_class = "";

		switch($cat_id)
		{
			case 1: $cat_color_class = "sports"; break;
			case 2: $cat_color_class = "lifestyle"; break;
			case 3: $cat_color_class = "news"; break;
			case 4: $cat_color_class = "showtime"; break;
			case 5: $cat_color_class = "tech"; break;
			case 6: $cat_color_class = "business"; break;
			case 7: $cat_color_class = "extra"; break;
			case 13: $cat_color_class = "expos"; break;
			case 14: $cat_color_class = "forums"; break;
			case 16: $cat_color_class = "frames"; break;
			case 17: $cat_color_class = "campain"; break;
			case 18: $cat_color_class = "articles"; break;
		}

		return $cat_color_class;
	}

	static function willad_comment($comment, $args, $depth) 
	{
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
	?>
		<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> >
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?> " class="comment comment-body">
		<?php endif; ?>
		<a href="" class="user-avatar">
	        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'], "", "", Array('class' => "img-circle") ); ?>
	    </a>


	<div class="comment-text">
	    <header>
		    <h5 class="pull-left"><?=get_comment_author_link() ?></h5>
		    <span class="time-stamp">
			<?php
				/* translators: 1: date, 2: time */
				printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?>
		   </span>
		    <a href="#" class="reply pull-right" style="display:block"><a rel="nofollow" class="comment-reply-link" data-replyto="<? comment_ID()?>" data-arialabel="Комментарий к записи <? comment_author()?>">Ответить</a></a>
		</header>
	   <?php comment_text(); ?>
	
		<? MQ_Voting::showVote_comment($comment->comment_ID)?>

	   <?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
			<br />
		<?php endif; ?>
		
		<div class="comment-meta commentmetadata">
			<?php edit_comment_link( __( '(Edit)' ), '  ', '' );?>
		</div>
	</div>
		
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
	<?php
}


static function breadcrumb() 
	{
		/* === ОПЦИИ === */
		$text['home'] = 'Главная'; // текст ссылки "Главная"
		$text['category'] = 'Архив рубрики "%s"'; // текст для страницы рубрики
		$text['search'] = 'Результаты поиска по запросу "%s"'; // текст для страницы с результатами поиска
		$text['tag'] = 'Записи с тегом "%s"'; // текст для страницы тега
		$text['author'] = 'Статьи автора %s'; // текст для страницы автора
		$text['404'] = 'Ошибка 404'; // текст для страницы 404

		$show_current = 1; // 1 - показывать название текущей статьи/страницы/рубрики, 0 - не показывать
		$show_on_home = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
		$show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
		$show_title = 1; // 1 - показывать подсказку (title) для ссылок, 0 - не показывать
		$delimiter = ' / '; // разделить между "крошками"
		$before = '<span class="current">'; // тег перед текущей "крошкой"
		$after = '</span>'; // тег после текущей "крошки"
		/* === КОНЕЦ ОПЦИЙ === */

		global $post;
		global $wp_query;

		$home_link = home_url('/');
		$link_before = '<span typeof="v:Breadcrumb">';
		$link_after = '</span>';
		$link_attr = ' rel="v:url" property="v:title"';
		$link = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
		$parent_id = $parent_id_2 = $post->post_parent;
		$frontpage_id = get_option('page_on_front');

		if(is_home() || is_front_page())
		{
			if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

		}else{

			echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
			if($show_home_link == 1) 
			{
				echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';

				if($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
			}

			if(is_tax() && !is_category())
			{
				$this_cat = get_term($wp_query->queried_object->term_id, $wp_query->queried_object->taxonomy);
				$this_tax = get_taxonomy($wp_query->queried_object->taxonomy);

				echo "<a href='/" . $this_tax->rewrite['slug'] . "'>" . $this_tax->label . "</a>" . $delimiter;

				if($this_cat->parent != 0) 
				{
					$cats = self::get_term_parents($this_cat->parent, $wp_query->queried_object->taxonomy, TRUE, $delimiter);

					if($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);

					$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
					$cats = str_replace('</a>', '</a>' . $link_after, $cats);
					
					if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
					
					echo  $cats;
				}

				if ($show_current == 1) echo $before . sprintf($this_cat->name) . $after;

			}elseif(is_category())
			{
				$this_cat = get_category(get_query_var('cat'), false);

				if($this_cat->parent != 0) 
				{
					$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);

					if($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);

					$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
					$cats = str_replace('</a>', '</a>' . $link_after, $cats);
					
					if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
					
					echo $cats;
				}

				if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

			}elseif(is_search())
			{
				echo $before . sprintf($text['search'], get_search_query()) . $after;

			}elseif(is_day()) 
			{
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
				echo $before . get_the_time('d') . $after;

			}elseif(is_month())
			{
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo $before . get_the_time('F') . $after;

			}elseif(is_year()) 
			{
				echo $before . get_the_time('Y') . $after;

			}elseif(is_single() && !is_attachment())
			{
				if(get_post_type() != 'post')
				{
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					printf($link, $home_link . $slug['slug'] . '/', $post_type->labels->singular_name);
				
					if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
				
				}else{

					$cat = get_the_category();
					$cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					
					if($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					
					$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
					$cats = str_replace('</a>', '</a>' . $link_after, $cats);
					
					if($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
					
					echo $cats;
					
					if($show_current == 1) echo $before . get_the_title() . $after;
				}

			}elseif(!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) 
			{
				$post_type = get_post_type_object(get_post_type());
				echo $before . $post_type->labels->singular_name . $after;

			}elseif(is_attachment())
			{
				$parent = get_post($parent_id);
				$cat = get_the_category($parent->ID); $cat = $cat[0];

				if($cat)
				{
					$cats = get_category_parents($cat, TRUE, $delimiter);
					$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
					$cats = str_replace('</a>', '</a>' . $link_after, $cats);

					if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);

					echo $cats;
				}

				printf($link, get_permalink($parent), $parent->post_title);
				if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

			}elseif(is_page() && !$parent_id) 
			{				
				if ($show_current == 1) echo $before . get_the_title() . $after;	

			}elseif(is_page() && $parent_id) 
			{
				if ($parent_id != $frontpage_id) 
				{
					$breadcrumbs = array();

					while($parent_id) 
					{
						$page = get_page($parent_id);

						if($parent_id != $frontpage_id)
						{
							$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
						}

						$parent_id = $page->post_parent;
					}

					$breadcrumbs = array_reverse($breadcrumbs);
					
					for($i = 0; $i < count($breadcrumbs); $i++) 
					{
						echo $breadcrumbs[$i];
						if ($i != count($breadcrumbs)-1) echo $delimiter;
					}
				}

				if($show_current == 1)
				{
					if($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
					echo $before . get_the_title() . $after;
				}

			}elseif(is_tag())
			{
				echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

			}elseif(is_author())
			{
		 		global $author;
				$userdata = get_userdata($author);
				echo $before . sprintf($text['author'], $userdata->display_name) . $after;

			}elseif(is_404())
			{			
				echo $before . $text['404'] . $after;

			}elseif(has_post_format() && !is_singular())
			{
				echo get_post_format_string(get_post_format());
			}

			if(get_query_var('paged')) 
			{
				if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ' (';
				echo 'Страница ' . get_query_var('paged');
				if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ')';
			}

			echo '</div><!-- .breadcrumbs -->';
		}
	} // end dimox_breadcrumbs()

	static function get_term_parents( $id, $taxonomy, $link = false, $separator = '/', $nicename = false, $visited = array() ) 
	{
		$chain = '';
		$parent = get_term($id, $taxonomy);
		

		if (is_wp_error($parent))
			return $parent;

		if ($nicename)
			$name = $parent->slug;
		else
			$name = $parent->name;

		if ($parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited)) 
		{
			$visited[] = $parent->parent;
			$chain .= self::get_term_parents($parent->parent, $taxonomy, $link, $separator, $nicename, $visited);
		}

		if ($link)
		{
			$chain .= '<a href="' . esc_url( get_term_link( intval( $parent->term_id ), $taxonomy ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $parent->name ) ) . '">'.$name.'</a>' . $separator;	
		}else{
			$chain .= $name.$separator;	
		}
		
		return $chain;
	}
}

?>