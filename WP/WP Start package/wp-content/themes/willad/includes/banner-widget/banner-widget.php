<?php  /**
 * Contact Details &amp; Maps Widget
 *
 * This file is used to register and display the Layers - Portfolios widget.
 *
 * @package Layers
 * @since Layers 1.0.0
 */
if( !class_exists( 'Willad_Banner_Widget' ) ) {
	class Willad_Banner_Widget extends WP_Widget {

		/**
		*  Widget construction
		*/
 	 	public function __construct() 
 	 	{
       		parent::__construct("banner_widget", "Баннер",
            array("description" => ""));
    	}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) {
	 		
	 		extract($instance);
	 		?>
<!-- start:advertising -->
<div class="ad">
    <a href="<?=$title?>">
    	<img src="<?=$img_src?>" alt="">
    </a>  
</div>
<!-- end:advertising -->
	 		<?	
	 	}

		/**
		*  Widget update
		*/
		public function update($newInstance, $oldInstance) {
		    $values = array();
		    $values["title"] = htmlentities($newInstance["title"]);
		    $values["img_src"] = htmlentities($newInstance["img_src"]);
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
		    $img_src = "";

		    // если instance не пустой, достанем значения
		    if (!empty($instance)) {
		        $title = $instance["title"];
		        $img_src = $instance["img_src"];
		    }
		 
		    $tableId = $this->get_field_id("title");
		    $tableName = $this->get_field_name("title");
		    echo '<label for="' . $tableId . '">Ссылка для перехода</label><br>';
		    echo '<input id="' . $tableId . '" type="text" name="' .
		    $tableName . '" value="' . $title . '"><br>';
		 
		    $textId = $this->get_field_id("img_src");
		    $textName = $this->get_field_name("img_src");
		    echo '<label for="' . $textId . '">Ссылка на картинку</label><br>';
		    echo '<textarea id="' . $textId . '" width="100%" rows=5 name="' . $textName .
		    '">' .  $img_src . '</textarea>';
		} // Form
	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Willad_Banner_Widget");
}