<?php  /**
 * Contact Details &amp; Maps Widget
 *
 * This file is used to register and display the Layers - Portfolios widget.
 *
 * @package Layers
 * @since Layers 1.0.0
 */
if( !class_exists( 'Willad_Weekly_Photos_Widget' ) ) {
	class Willad_Weekly_Photos_Widget extends WP_Widget {

		/**
		*  Widget construction
		*/
 	 	public function __construct() 
 	 	{
       		parent::__construct("weekly_photos_widget", "Фото за неделю",
            array("description" => ""));
    	}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) {
	 		
            global $wpdb;
	 		extract($instance);

	 		$date = date('Y-m-d', strtotime('-7 days'));

	 		$attachments = $wpdb->get_results("SELECT * FROM " .  $wpdb->prefix . "posts WHERE post_parent > 0 AND post_type = 'attachment' ORDER BY RAND() LIMIT 4" );          

	 		$big = array_shift($attachments);

	 		?>

<!-- start:section-module-photos -->
                        <section class="module-photos">
                            <!-- start:header -->
                            <header>
                                <h2><?=$title?></h2>
                                <span class="borderline"></span>
                            </header>
                            <!-- end:header -->
                            <!-- start:article-container -->
                            <div id="weekly-gallery" class="article-container">
                                <!-- start:row -->
                                <div class="row">
                                    <!-- start:article -->
                                    <article class="clearfix">
                                       <?/* <p>Aliquam sollicitudin, enim sit amet hendrerit consequat, velit orci posuere elit, eu facilisis lacus odio ac nunc. </p>
                                       */?>
                                        <a href="<?=$big->guid?>">
                                            <img src="<?=$big->guid?>" width="300" height="200" alt="Responsive image" class="img-responsive" />
                                        </a>
                                    </article>
                                    <!-- end:article -->
                                </div>
                                <!-- end:row -->
                                <? if(count($attachments) > 0){?>
                                <!-- start:row -->
                                <div class="row">
                                	<?
                                		$span = 12 / count($attachments);
                                		foreach($attachments as $attach){
                                	?>
                                    <!-- start:col -->
                                    <div class="col-xs-<?=$span?>">
                                        <!-- start:article -->
                                        <article class="clearfix">
                                            <a href="<?=$attach->guid?>" style="background: url(<?=$attach->guid?>) center; background-size:cover; height:75px">                                            	<img src="<?=$attach->guid?>" style="display:none" alt="">
                                            </a>
                                        </article>
                                        <!-- end:article -->
                                    </div>
                                    <!-- end:col -->                                   
                                    <?}?>
                                </div>
                                <!-- end:row -->
                                <?}?>
                            </div>
                            <!-- end:article-container -->
                        </section>
                        <!-- end:section-module-photos -->
	 		<?	
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
	 register_widget("Willad_Weekly_Photos_Widget");
}