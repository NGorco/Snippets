<?/*
// Plugin Name: ThemeWiki Plugin
// Author: Alex Petlenko aka Massique
// Site: http://massique.com
*/

$pldirpath = plugin_dir_path(__FILE__);

add_action('init', 'wiki_post_type_register');

function wiki_post_type_register(){

	global $pldirpath;

	$labels = array(
		 'name' => 'Wiki items' // основное название для типа записи
		,'singular_name' => 'Wiki item' // название для одной записи этого типа
		,'add_new' => 'Add new Wiki item' // для добавления новой записи
		,'add_new_item' => '' // заголовка у вновь создаваемой записи в админ-панели.
		,'edit_item' => 'Edit Wiki item' // для редактирования типа записи
		,'new_item' => 'New Wiki Item' // текст новой записи
		,'view_item' => 'View Wiki item' // для просмотра записи этого типа.
		,'search_items' => 'Search Wiki items' // для поиска по этим типам записи
		,'not_found' => '' // если в результате поиска ничего не было найдень
		,'not_found_in_trash' => '' // если не было найдено в корзине
		,'parent_item_colon' => '' // для родительских типов. для древовидных типов
		,'menu_name' => 'ThemeWiki' // название меню
	);
	$args = array(
		 'label' => null 
		,'labels' => $labels 
		,'description' => '' 
		,'public' => true 
		,'publicly_queryable' => true
		,'exclude_from_search' => true
		,'show_ui' => true
		,'show_in_menu' => true
		,'menu_position' => null 
		,'menu_icon' => null 
		,'capability_type' => 'page' 
		,'hierarchical' => true
		,'supports' => array('title','editor', 'thumbnail','page-attributes')
		//,'taxonomies' => array('wikisection')
		,'has_archive' => false
		,'rewrite' => true
		,'query_var' => true
		,'show_in_nav_menus' => null
	);
	register_post_type( 'wiki', $args );


	// заголовки
	$labels = array(
		'name'              => 'Wiki categories',
		'singular_name'     => 'Wiki category',
		'search_items'      => 'Search Wiki categories',
		'all_items'         => 'All Wiki categories',
		'parent_item'       => 'Parent Wiki category',
		'parent_item_colon' => 'Parent Wiki category:',
		'edit_item'         => 'Edit Wiki category',
		'update_item'       => 'Update Wiki category',
		'add_new_item'      => 'Add New Wiki category',
		'new_item_name'     => 'New Wiki category Name',
		'menu_name'         => 'Wiki category',
	); 
	// параметры
	$args = array(
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => $labels,
		'public'                => true,
		'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_tagcloud'         => true, // равен аргументу show_ui
		'hierarchical'          => true,
		'update_count_callback' => '',
		'rewrite'               => array('hierarchical'=>true, 'slug'=>'wiki'),
		'query_var'             => '',
		'capabilities'          => array('manage_terms', 'edit_terms', 'delete_terms', 'assign_terms'),
		'meta_box_cb'           => null, // callback функция. Отвечает за html код метабокса (с версии 3.8): post_categories_meta_box или post_tags_meta_box. Если указать false, то метабокс будет отключен вообще
		'show_admin_column'     => true, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи. (с версии 3.5)
		'_builtin'              => false,
		'show_in_quick_edit'    => true, // по умолчанию значение show_ui
	);
	register_taxonomy('wikisection', array(''), $args );


//include the main class file
require_once( $pldirpath . "/core/helpers/tax-metabox/Tax-meta-class.php");
if (is_admin()){
  /* 
   * prefix of meta keys, optional
   */
  $prefix = 'ba_';
  /* 
   * configure your meta box
   */
  $config = array(
    'id' => 'demo_meta_box',          // meta box id, unique per meta box
    'title' => 'Demo Meta Box',          // meta box title
    'pages' => array('wikisection'),        // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),            // list of meta fields (can be added by field arrays)
    'local_images' => false     //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );
  
  
  /*
   * Initiate your meta box
   */
  $my_meta =  new Tax_Meta_Class($config);
  
  /*
   * Add fields to your meta box
   */
  
  //text field

  //Image field
  $my_meta->addImage($prefix.'image_field_id',array('name'=> __('Иконка раздела','tax-meta')));
  
  
  /*
   * Don't Forget to Close up the meta box decleration
   */
  //Finish Meta Box Decleration
  $my_meta->Finish();

  	// Не вошедшее в продакшн
	//add_action('add_meta_boxes', 'metatest_init'); 
	//add_action('save_post', 'metatest_save'); 

	function metatest_init() { 
	add_meta_box('metatest', 'Параметры статьи', 	'metatest_showup', 'wiki', 'side', 'default'); 
	} 

function metatest_showup($post, $box) { 

// получение существующих метаданных 
$data = get_post_meta($post->ID, '_meta_data', true); 

// скрытое поле с одноразовым кодом 
wp_nonce_field('metatest_action', 'metatest_nonce'); 

// поле с метаданными 
echo '<p><input type="checkbox" id="show_like_section" name="metadata_field" ' . (esc_attr($data) == 'Y' ? " checked='checked' " : '') . ' value="Y"/> <label for="show_like_section">Отображать статью как раздел</label></p>'; 
} 


function metatest_save($postID) { 

if(empty($_POST)){

	return;
}
// не происходит ли автосохранение? 
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
return; 

// не ревизию ли сохраняем? 
if (wp_is_post_revision($postID)) 
return; 

// проверка достоверности запроса 
check_admin_referer('metatest_action', 'metatest_nonce'); 

// коррекция данных 
$data = sanitize_text_field($_POST['metadata_field']); 

// запись 
update_post_meta($postID, '_metatest_data', $data); 

} 




}



add_filter('single_template', 'wikisingle');

function wikisingle($single) {
    
    global $wp_query, $post;

	/* Checks for single template by post type */
	if ($post->post_type == "wiki"){
	   
	   header("Location: /wiki/");
	}
	    return $single;
	}

add_filter('archive_template', 'wikiarchive');

function wikiarchive($archive) {
    
    global $wp_query, $post;

	/* Checks for single template by post type */
	if ($wp_query->query['taxonomy'] == "wikisection"){
	
	 	header("Location: /wiki/");
	}

	    return $archive;
	}



add_theme_support('menus');

add_filter('index_template', 'wikicat');

function wikicat($archive) {
    
    global $wp_query, $post, $pldirpath;

	/* Checks for single template by post type */
	if ($wp_query->query['category_name'] == "wiki"){
		
		  return $pldirpath . 'assets/templates/wiki.php';
	}
		
	    return $archive;
	}
}


add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once  $pldirpath . 'core/helpers/custom-options-metabox/init.php';

}

include_once( $pldirpath . 'assets/templates/options.php');



?>