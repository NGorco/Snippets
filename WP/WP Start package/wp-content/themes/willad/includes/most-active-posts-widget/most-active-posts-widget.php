<?php  /**
 * Contact Details &amp; Maps Widget
 *
 * This file is used to register and display the Layers - Portfolios widget.
 *
 * @package Layers
 * @since Layers 1.0.0
 */
if( !class_exists( 'Willad_Most_Active_Themes_Widget' ) ) {
	class Willad_Most_Active_Themes_Widget extends WP_Widget {

		/**
		*  Widget construction
		*/
 	 	public function __construct() 
 	 	{
       		parent::__construct("most_active_posts_widget", "Самые активные темы",
            array("description" => ""));
    	}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) {
	 		
	 		extract($instance);
            global $wpdb;

            $cats = Array(1, 4, 7, 17, 18);
            $posts = Array();

            foreach($cats as $cat)
            {
                $post_tmp = $wpdb->get_results("SELECT * 
                    FROM " . $wpdb->prefix ."posts
                    LEFT JOIN " . $wpdb->prefix . "term_relationships AS rl 
                    ON ID = rl.object_id
                    WHERE rl.term_taxonomy_id = " . $cat . " AND
                    post_type = 'post' AND
                    post_status = 'publish'
                    ORDER BY comment_count DESC ");

                $post_tmp = array_shift($post_tmp);

                $post_tmp->cat = $cat;
                $posts[] = $post_tmp;
            }

          
            if(count($posts) > 0){
	 		?>

            <!-- start:section-module-news -->
            <section class="module-news top-margin most-active-posts-widget" style="background: #8e6161;">
                <!-- start:header -->
                <header>
                    <h2><?=$title?></h2>
                    <span class="borderline"></span>
                </header>
                <!-- end:header -->
                
                <!-- start:article-container -->
                <div class="article-container">
                    <? $cnt = 0; foreach($posts as $post)
                    {
                        $theme = get_post($post->ID);

                        $date = new DateTime($theme->post_date);
                        $cat = get_category($post->cat);

                        ?>
                        <!-- start:article -->
                        <article class="clearfix">
                            <a href="<?=get_post_permalink($theme->ID);?>">
                                <?=get_the_post_thumbnail($theme->ID, 'thumbnail');?>
                            </a>
                            <span class="published">
                                <?=$date->format('d.m.Y')?>
                                <span class="category cat-<?=CUtil::cat_color($post->cat)?>">
                                    <a href="<?=get_category_link($post->cat );?>">
                                        <?=$cat->name?>
                                    </a>
                                </span>
                            </span>
                            <h3><a href="<?=get_post_permalink( $theme->ID)?>"><?=CUtil::titleCut(strip_tags($theme->post_content), 250)?></a></h3>
                        </article>
                        <!-- end:article -->                   
                    <?}?>
                </div>
                <!-- end:article-container -->
            </section>
            <!-- end:section-module-news -->
	 		<?	}
	 	}

		/**
		*  Widget update
		*/
		public function update($newInstance, $oldInstance) {
		    $values = array();
		    $values["title"] = htmlentities($newInstance["title"]);
		    return $values;
		}

		/**
		*  Widget form
		*
		* We use regulage HTML here, it makes reading the widget much easier than if we used just php to echo all the HTML out.
		*
		*/
		function form( $instance )
		{
			$title = "";
		    // если instance не пустой, достанем значения
		    if (!empty($instance)) {
		        $title = $instance["title"];
		    }
		 
		    $tableId = $this->get_field_id("title");
		    $tableName = $this->get_field_name("title");
		    echo '<label for="' . $tableId . '">Заголовок</label><br>';
		    echo '<input id="' . $tableId . '" type="text" name="' .
		    $tableName . '" value="' . $title . '"><br>';		 
		} // Form
	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Willad_Most_Active_Themes_Widget");
}