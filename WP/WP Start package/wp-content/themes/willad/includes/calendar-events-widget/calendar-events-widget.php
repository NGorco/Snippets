<?php  /**
 * Contact Details &amp; Maps Widget
 *
 * This file is used to register and display the Layers - Portfolios widget.
 *
 * @package Layers
 * @since Layers 1.0.0
 */
if( !class_exists( 'Willad_Calendar_Events_Widget' ) ) {
	class Willad_Calendar_Events_Widget extends WP_Widget {

		/**
		*  Widget construction
		*/
 	 	public function __construct() 
 	 	{
       		parent::__construct("calendar_events_widget", "События календаря",
            array("description" => ""));
    	}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) 
	 	{
	 		extract($instance);

	 		$events = get_posts(array('post_type' => 'events','meta_key' => 'event_date', 'order' => 'asc', 'orderby' => 'meta_value', 'posts_per_page' => $events_count));
	 		$out = Array();

	 		foreach ($events as $key => $event) {
	 			
	 			$category = array_shift(get_the_category( $event->ID ));
	 			
	 			$event_date_meta = get_post_meta( $event->ID, 'event_date', true );

	 			$date = new DateTime($event_date_meta);
	 			$event->cat_href = get_category_link($category->term_id );
	 			$event->date = $date->format('d.m.Y');
	 			$event->time = $date->format('H:i');
	 			$event->cat_color = CUtil::cat_color($category->term_id);
	 			$event->cat = $category->name;
	 			$tmp = $event;
	 			$out[] = $tmp;
	 		}
	 		?>
			<section class="module-timeline">
			    <!-- start:header -->
			    <header>
			    	<? if(is_user_logged_in()){?>
						<a href="/events-calendar">
							<h2><?=$title?></h2>
						</a>
			    	<?}else{?>
			        <h2><?=$title?></h2>
			        <?}?>
			        <span class="borderline"></span>
			    </header>
			    <!-- end:header -->
			    <!-- start:articles -->
			    <div class="articles">
			    <? foreach($out as $event){?>			    
			        <article>
			            <span class="published"><?=$event->date?></span>
			            <!--span class="published-time"><?=$event->time?></span-->
			            <div class="cnt">
			                <i class="bullet bullet-<?=$event->cat_color?>"></i>
			                <span class="category cat-<?=$event->cat_color?>"><a href="<?=$event->cat_href?>"><?=$event->cat?></a></span>
			                <h3><a href="<?=get_permalink($event->ID);?>"><?=$event->post_title?></a></h3>
			            </div>                                
			        </article>			   
			    <?}?>
			    </div>
			    <!-- end:articles -->
			</section>
	 		<?	
	 	}

		/**
		*  Widget update
		*/
		public function update($newInstance, $oldInstance) {
		    $values = array();
		    $values["title"] = htmlentities($newInstance["title"]);
		    $values["events_count"] = htmlentities($newInstance["events_count"]);
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
		    $events_count = "1";

		    // если instance не пустой, достанем значения
		    if (!empty($instance)) {
		        $title = $instance["title"];
		        $events_count = $instance["events_count"];
		    }
		 
		    $tableId = $this->get_field_id("title");
		    $tableName = $this->get_field_name("title");
		    echo '<label for="' . $tableId . '">Заголовок</label><br>';
		    echo '<input id="' . $tableId . '" type="text" name="' .
		    $tableName . '" value="' . $title . '"><br>';
		 
		    $textId = $this->get_field_id("events_count");
		    $textName = $this->get_field_name("events_count");
		    echo '<label for="' . $textId . '">Количество постов</label><br>';
		    echo '<input type="number" min="1" id="' . $textId . '" value="' .  $events_count . '" name="' . $textName .
		    '">';
		} // Form
	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Willad_Calendar_Events_Widget");
}