<?php
/*
* Custom post type metaboxes class
*/

class QMetaBox{

	private $tabname = "";
	private $posttype = "";
	private $position = "advanced";
	private $fields = Array();

	public function __construct($args)
	{
		$this->tabname = $args['tabname'];
		$this->posttype = $args['posttype'];
		$this->id = $args['id'];

		if($args['position'])
		$this->position = $args['position'];

		$this->fields = $args['fields']; // this should be an multidimensional array

		add_action('add_meta_boxes', array($this, 'add_metabox_method'));
		add_action('save_post', array($this, 'save_post'), 1, 2); // save the custom fields
	}

	public function add_metabox_method()
	{
		add_meta_box($this->id ,$this->tabname, array($this, 'render_metaboxes'), $this->posttype, $this->position, 'default');	
	}

	public function render_metaboxes()
	{
		global $post;
	
		// Noncename needed to verify where the data originated
		echo '<input type="hidden" name="' . $this->id . '_noncename" id="' . $this->id . '_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
		
		foreach($this->fields as $field)
		{
			$this->renderSingleMetaBox($field);
		}
	}

	private function renderSingleMetaBox($field)
	{
		$data = get_post_meta($post->ID, $field['name'], true);
		pre($data);
		if(!isset($field['type']) || $field['type'] == 'text')
		{?>
		<p><?=$field['label']?><input type="text" name="<?=$field['name']?>" value="<?=$data?>" /></p>
		<?}

		if($field['type'] == 'checkbox')
		{?>
		<p>
			<input type="checkbox" name="<?=$field['name']?>" id="<?=$field['name']?>_chkbx" <?=($data == "Y" ? "checked=checked" : "")?> value="Y" />
			<label for="<?=$field['name']?>_chkbx"><?=$field['label']?></label>
		</p>
		<?}

		if($field['type'] == 'textarea')
		{?>
		<p><?=$field['label']?><br>
		<textarea name="<?=$field['name']?>" id="" cols="30" rows="5"><?=($data?$data:"")?></textarea>
		</p>
		<?}
	}

	public function save_post($post_id, $post)
	{	
		if(!wp_verify_nonce($_POST[$this->id . '_noncename'], plugin_basename(__FILE__))) 
		{
			return $post->ID;
		}

		if (!current_user_can( 'edit_post', $post->ID ))
			return $post->ID;

		$meta_arr = Array();
		
		foreach($this->fields as $field)
		{
			$meta_arr[$field['name']] = $_POST[$field['name']];	
		}


		foreach($meta_arr as $key => $value) // Cycle through the $events_meta array!
		{ 
			if($post->post_type == 'revision') return; // Don't store custom data twice

			$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)

			if(get_post_meta($post->ID, $key, FALSE)) // If the custom field already has a value
			{ 
				update_post_meta($post->ID, $key, $value);
			} else { // If the custom field doesn't have a value

				add_post_meta($post->ID, $key, $value);
			}

			if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
		}
	}
}
?>