<?php 

namespace UniqueElementorToolkit;

use UniqueElementorToolkit\PageSettings\Page_Settings;
use UniqueElementorToolkit\Widgets\Unique_Cool_Card;
use UniqueElementorToolkit\Widgets\Unique_Button;


class Plugin {
    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Enqueue widget styles
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function widget_scripts() {

        // css
        wp_enqueue_style( 'uewtk-cool-card', plugins_url( '/assets/widgets-css/uewtk-cool-card.css', __FILE__ ) );
        wp_enqueue_style( 'uewtk-button-css', plugins_url( '/assets/widgets-css/uewtk-button.css', __FILE__ ) );
    
        // js
        wp_enqueue_script('uewtk-button-js', plugins_url( '/assets/widgets-js/uewtk-button.js', __FILE__ ), array( 'jquery' ), '1.0.0', true);

    }


    public function editor_scripts() {
        add_filter( 'script_loader_tag', [ $this, 'editor_scripts_as_a_module' ], 10, 2 );

        wp_enqueue_script(
            'elementor-hello-world-editor',
            plugins_url( '/assets/js/editor/editor.js', __FILE__ ),
            [ 'elementor-editor' ],
            '1.2.1',
            true
        );
    }

    public function editor_scripts_as_a_module( $tag, $handle ) {
        if ( 'elementor-hello-world-editor' === $handle ) {
            $tag = str_replace( '<script', '<script type="module"', $tag );
        }
        return $tag;
    }

    public function register_widgets( $widgets_manager ) {
        

        require_once( __DIR__ . '/widgets/uewtk-cool-card.php' );
        require_once( __DIR__ . '/widgets/uewtk-button.php' );
      

     
        $widgets_manager->register( new Unique_Cool_Card() );
        $widgets_manager->register( new Unique_Button() );
       
    }

    private function add_page_settings_controls() {
        require_once( __DIR__ . '/page-settings/manager.php' );
        new Page_Settings();
    }
    

    public function register_category() {
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'unique-elementor-widget-toolkit',
            [
                'title' => __( 'Unique Toolkit', 'unique-elementor-widget-toolkit' ),
                'icon' => 'font',
                'position' => 2, // Set a low number to position it at the top
            ]
        );
    }

    public function uewtk_react_enqueue_scripts( $hook ) {
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
            true
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

    public function uewtk_admin_menu() {
        add_menu_page( 
            __( 'Unique Toolkit', 'unique-elementor-widget-toolkit' ),
            'Unique Toolkit',
            'manage_options',
            'unique-elementor-widget-toolkit',
            [$this, 'uewtk_menu_page'],
            'dashicons-editor-underline',
            6
        ); 
    }

    public function uewtk_menu_page() {
        echo '<div id="root"></div>';	
    }

    public function __construct() {
        add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'editor_scripts']);
        add_action('elementor/elements/categories_registered', [$this, 'register_category']);
        add_action('admin_enqueue_scripts', [$this, 'uewtk_react_enqueue_scripts']);
        add_action('admin_menu', [$this, 'uewtk_admin_menu']);
        $this->add_page_settings_controls();
    }
}

// Instantiate Plugin Class
Plugin::instance();