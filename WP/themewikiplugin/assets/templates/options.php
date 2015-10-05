<?
/**
 * CMB Theme Options
 * @version 0.1.0
 */
class themewiki_Admin {

    /**
     * Option key, and option page slug
     * @var string
     */
    private $key = 'themewiki_options';

    /**
     * Array of metaboxes/fields
     * @var array
     */
    protected $option_metabox = array();

    /**
     * Options Page title
     * @var string
     */
    protected $title = '';

    /**
     * Options Page hook
     * @var string
     */
    protected $options_page = '';

    /**
     * Constructor
     * @since 0.1.0
     */
    public function __construct() {
        // Set our title
        $this->title = __( 'ThemeWiki', 'themewiki' );

        // Set our CMB fields
        $this->fields = array(

            array(
                'name' => 'ThemeWiki page title',
                'desc' => '',
                'default' => '',
                'id' => 'wiki_page_title',
                'type' => 'text_medium'
            ),
            array(
                'name' => 'Header Logo',
                'desc' => 'Upload an image or enter an URL.',
                'id' =>  'header_logo',
                'type' => 'file',
                'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
            ),
            array(
                'name'    => 'Header main text',
                'id'      => 'header_main_text',
                'type'    => 'wysiwyg',
                'options' => array( 'textarea_rows' => 5, ),
            ),
            array(
                'name' => 'Header top menu',
                'desc' => 'Enter menu name',
                'default' => '',
                'id' => 'header_top_menu',
                'type' => 'text_medium'
            ),
            array(
                'name' => 'Header Background',
                'desc' => 'Upload an image or enter an URL.',
                'id' =>  'header_background',
                'type' => 'file',
                'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
            ),
        );
    }

    

    /**
     * Initiate our hooks
     * @since 0.1.0
     */
    public function hooks() {
        add_action( 'admin_init', array( $this, 'init' ) );
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
    }

    /**
     * Register our setting to WP
     * @since  0.1.0
     */
    public function init() {
        register_setting( $this->key, $this->key );
    }

    /**
     * Add menu options page
     * @since 0.1.0
     */
    public function add_options_page() {
        $this->options_page = add_submenu_page( 'edit.php?post_type=wiki', $this->title . ' options', $this->title . ' options', 'manage_options', 'themewiki-options',  array( $this, 'admin_page_display' ) );
       // $this->options_page = add_menu_page( $this->title, , 'manage_options', $this->key,,'',40 );
    }

    /**
     * Admin page markup. Mostly handled by CMB
     * @since  0.1.0
     */
    public function admin_page_display() {
        ?>
        <div class="wrap cmb_options_page <?php echo $this->key; ?>">
            <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
            <?php cmb_metabox_form( $this->option_metabox(), $this->key ); ?>
        </div>
        <?php
    }

    /**
     * Defines the theme option metabox and field configuration
     * @since  0.1.0
     * @return array
     */
    public function option_metabox() {
        return array(
            'id'         => 'option_metabox',
            'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
            'show_names' => true,
            'fields'     => $this->fields,
        );
    }

    /**
     * Public getter method for retrieving protected/private variables
     * @since  0.1.0
     * @param  string  $field Field to retrieve
     * @return mixed          Field value or exception is thrown
     */
    public function __get( $field ) {

        // Allowed fields to retrieve
        if ( in_array( $field, array( 'key', 'fields', 'title', 'options_page' ), true ) ) {
            return $this->{$field};
        }
        if ( 'option_metabox' === $field ) {
            return $this->option_metabox();
        }

        throw new Exception( 'Invalid property: ' . $field );
    }

}

// Get it started
$themewiki_Admin = new themewiki_Admin();
$themewiki_Admin->hooks();

/**
 * Wrapper function around cmb_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function themewiki_get_option( $key = '' ) {
    global $themewiki_Admin;
    return cmb_get_option( $themewiki_Admin->key, $key );
}