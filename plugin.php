<?php
namespace UniqueElementorToolkit;

use UniqueElementorToolkit\PageSettings\Page_Settings;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

    /**
     * Instance
     *
     * @since 1.2.0
     * @access private
     * @static
     *
     * @var Plugin The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.2.0
     * @access public
     *
     * @return Plugin An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * widget_scripts
     *
     * Load required plugin core files.
     *
     * @since 1.2.0
     * @access public
     */
    public function widget_scripts() {
        wp_register_script( 'elementor-hello-world', plugins_url( '/assets/js/hello-world.js', __FILE__ ), [ 'jquery' ], false, true );
    }

    /**
     * Editor scripts
     *
     * Enqueue plugin javascripts integrations for Elementor editor.
     *
     * @since 1.2.1
     * @access public
     */
    public function editor_scripts() {
        add_filter( 'script_loader_tag', [ $this, 'editor_scripts_as_a_module' ], 10, 2 );

        wp_enqueue_script(
            'elementor-hello-world-editor',
            plugins_url( '/assets/js/editor/editor.js', __FILE__ ),
            [
                'elementor-editor',
            ],
            '1.2.1',
            true
        );
    }

    /**
     * Force load editor script as a module
     *
     * @since 1.2.1
     *
     * @param string $tag
     * @param string $handle
     *
     * @return string
     */
    public function editor_scripts_as_a_module( $tag, $handle ) {
        if ( 'elementor-hello-world-editor' === $handle ) {
            $tag = str_replace( '<script', '<script type="module"', $tag );
        }

        return $tag;
    }

    /**
     * Register Widgets
     *
     * Register new Elementor widgets.
     *
     * @since 1.2.0
     * @access public
     *
     * @param Widgets_Manager $widgets_manager Elementor widgets manager.
     */
    public function register_widgets( $widgets_manager ) {
        // Its is now safe to include Widgets files
        require_once( __DIR__ . '/widgets/hello-world.php' );
        require_once( __DIR__ . '/widgets/inline-editing.php' );

        // Register Widgets
        $widgets_manager->register( new Widgets\Hello_World() );
        $widgets_manager->register( new Widgets\Inline_Editing() );
    }

    /**
     * Add page settings controls
     *
     * Register new settings for a document page settings.
     *
     * @since 1.2.1
     * @access private
     */
    private function add_page_settings_controls() {
        require_once( __DIR__ . '/page-settings/manager.php' );
        new Page_Settings();
    }

    /**
     * Enqueue React app scripts and styles
     *
     * @param string $hook
     */
    public function hello_react_enqueue_scripts( $hook ) {
       
    

        $asset_file = plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

        if ( ! file_exists( $asset_file ) ) {
            return;
        }

        $asset = include $asset_file;

        wp_enqueue_script(
            'hello-react-script',
            plugins_url( 'build/index.js', __FILE__ ),
            $asset['dependencies'],
            $asset['version'],
            true // Load in footer
        );

        $css_handle = is_rtl() ? 'hello-react-style-rtl' : 'hello-react-style';
        $css_file = is_rtl() ? 'build/index-rtl.css' : 'build/index.css';
        wp_enqueue_style(
            $css_handle,
            plugins_url( $css_file, __FILE__ ),
            array_filter(
                $asset['dependencies'],
                function ( $style ) {
                    return wp_style_is( $style, 'registered' );
                }
            ),
            $asset['version']
        );
    }

    /**
     * Register admin menu page
     */
   
    /**
     * Admin menu callback
     */
   
    public function uewtk_admin_menu(){
       add_menu_page( 
           __( 'Unique Toolkit', 'unique-elementor-widget-toolkit' ),
           'Unique Toolkit',
           'manage_options',
           'unique-toolkit',
           [$this, 'uewtk_menu_page'],
           'dashicons-editor-underline',
           6
       ); 
   }
   
   
   /**
    * Display a custom menu page
    */
   public function uewtk_menu_page(){
       echo '<div id="root"></div>';	
   }


    /**
     * Plugin class constructor
     *
     * Register plugin action hooks and filters
     *
     * @since 1.2.0
     * @access public
     */
    public function __construct() {
        // Register widget scripts
        add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);

        // Register widgets
        add_action('elementor/widgets/register', [$this, 'register_widgets']);

        // Register editor scripts
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'editor_scripts']);

        // Enqueue React app scripts
        add_action('admin_enqueue_scripts', [$this, 'hello_react_enqueue_scripts']);

        add_action( 'admin_menu', [$this, 'uewtk_admin_menu'] );

        $this->add_page_settings_controls();
    }
}

// Instantiate Plugin Class
Plugin::instance();