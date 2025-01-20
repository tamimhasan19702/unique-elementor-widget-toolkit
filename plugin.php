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

	
	public function enqueue_admin_frontend_assets() {
		$admin_frontend_assets = plugin_dir_url(__FILE__) . 'admin-frontend/dist/';

		// enqueue main js
		wp_enqueue_script('unique-elementor-widget-toolkit-admin-frontend-script', $admin_frontend_assets . 'assets/index-8h-hXAGN.js', array(), null, true);

		// enqueue main css
		wp_enqueue_style('unique-elementor-widget-toolkit-admin-frontend-style', $admin_frontend_assets . 'assets/index-n_ryQ3BS.css');
	}

	public function register_shortcodes() {
        add_shortcode('react_app', [$this, 'render_react_app_shortcode']);
    }

	public function render_react_app_shortcode() {
        return '<div id="root"></div>'; // This is where your React app will be mounted
    }

	public function register_custom_post_type() {
		$labels = array(
			'name' => __( 'Unique Elementor Widget Toolkits', 'unique-elementor-widget-toolkit' ),
			'singular_name' => __( 'Unique Elementor Widget Toolkit', 'unique-elementor-widget-toolkit' ),
		);
	
		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor'), // Add 'editor' to support content
			'menu_icon' => 'dashicons-screenoptions', // Add a widget icon
			'capability_type' => 'post',
			'capabilities' => array(
				'create_posts' => 'do_not_allow',
			),
			'map_meta_cap' => true,
		);
	
		register_post_type( 'uewtk', $args );
	
		// Set default content for the custom post type
		add_filter('default_content', [$this, 'set_default_content'], 10, 2);
	}
	
	/**
	 * Set default content for the custom post type
	 *
	 * @param string $content The default content.
	 * @param WP_Post $post The post object.
	 * @return string Modified content.
	 */
	public function set_default_content($content, $post) {
		if ($post->post_type === 'uewtk') {
			$content = '[react_app]'; // Set the default content to the shortcode
		}
		return $content;
	}


	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *a
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Register editor scripts
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_scripts' ] );

		add_action('init', [$this, 'register_custom_post_type']);

		add_action('init', [$this, 'register_shortcodes']);

		// add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_frontend_assets']);
		
		$this->add_page_settings_controls();
	}



}

// Instantiate Plugin Class
Plugin::instance();