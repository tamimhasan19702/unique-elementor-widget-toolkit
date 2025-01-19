<?php
/**
 * Plugin Name: Unique Sphere Widget Toolkit
 * Description: An Elementor widget toolkit designed to add unique, innovative, and awesome widgets for enhancing your website's functionality and appearance. Explore endless possibilities with custom widgets tailored to meet your needs.
 * Version:     1.0.0
 * Author:            Tareq Monower
 * Author URI:        https://profiles.wordpress.org/tamimh/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       holiday-calendar
 * Elementor tested up to: 3.5.0
 * Elementor Pro tested up to: 3.5.0
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Unique Sphere Class
 *
 * The init class that runs the Unique Sphere plugin.
 * Intended to make sure that the plugin's minimum requirements are met.
 *
 * @since 1.0.0
 */
final class Unique_Sphere_Elementor {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
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
	 * Checks for basic plugin requirements.
	 *
	 * @since 1.0.0
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

		// Once we get here, we have passed all validation checks so we can safely include our plugin
		require_once( 'includes/class-unique-sphere-main.php' );


	}

	/**
	 * Run the plugin
	 *
	 * This function is responsible for executing the core functionality of the plugin.
	 *
	 * @since 1.0.0
	 * @access public
	 */

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
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'unique-sphere-elementor' ),
			'<strong>' . esc_html__( 'Unique Sphere Elementor Addon', 'unique-sphere-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'unique-sphere-elementor' ) . '</strong>'
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
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'unique-sphere-elementor' ),
			'<strong>' . esc_html__( 'Unique Sphere Elementor Addon', 'unique-sphere-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'unique-sphere-elementor' ) . '</strong>',
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
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'unique-sphere-elementor' ),
			'<strong>' . esc_html__( 'Unique Sphere Elementor Addon', 'unique-sphere-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'unique-sphere-elementor' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

// Activation and deactivation hooks
function uswtk_activate() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-uswtk-activator.php';
	USWTK_Activator::activate();
}

function uswtk_deactivate() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-uswtk-deactivator.php';
	USWTK_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'uswtk_activate');
register_deactivation_hook(__FILE__, 'uswtk_deactivate');

// Instantiate Unique_Sphere_Elementor.
new Unique_Sphere_Elementor();