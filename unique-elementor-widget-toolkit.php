<?php
/**
 * Plugin Name: Unique Elementor Widget Toolkit
 * Description: Enhance Elementor with unique and highly useful widgets.
 * Version:     1.0.0
 * Author:      Tareq Monower
 * Author URI:  https://profiles.wordpress.org/tamimh
 * Text Domain: unique-elementor-widget-toolkit
 * Elementor tested up to: 3.6.0
 * Elementor Pro tested up to: 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





define( 'UEWTK_VERSION', '1.0.0' );
define( 'UEWTK__FILE__', __FILE__ );
define( 'UEWTK_BASE', plugin_basename( __FILE__ ) );
define( 'UEWTK_DIR_PATH', plugin_dir_path( UEWTK__FILE__ ) );
define( 'UEWTK_DIR_URL', plugin_dir_url( UEWTK__FILE__ ) );
define( 'UEWTK_ASSETS', trailingslashit( UEWTK_DIR_URL . 'assets' ) );
define( 'UEWTK_WIDGET', trailingslashit( UEWTK_DIR_PATH . 'widgets' ) );





/**
 * Main Elementor Hello World Class
 *
 * The init class that runs the Hello World plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 * @since 1.2.0
 */
final class Unique_Elementor_Widget_Toolkit {


	const PAGE_SLUG = 'unique-elementor-widget-toolkit';


	/**
	 * Plugin Version
	 *
	 * @since 1.2.1
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.2.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.2.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'unique_elementor_widget_toolkit' ),
			'<strong>' . esc_html__( 'Unique Toolkit', 'unique_elementor_widget_toolkit' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'unique_elementor_widget_toolkit' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'unique_elementor_widget_toolkit' ),
			'<strong>' . esc_html__( 'Unique Toolkit', 'unique_elementor_widget_toolkit' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'unique_elementor_widget_toolkit' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'unique_elementor_widget_toolkit' ),
			'<strong>' . esc_html__( 'Unique Toolkit', 'unique_elementor_widget_toolkit' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'unique_elementor_widget_toolkit' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

// Instantiate Elementor_Hello_World.
new Unique_Elementor_Widget_Toolkit();