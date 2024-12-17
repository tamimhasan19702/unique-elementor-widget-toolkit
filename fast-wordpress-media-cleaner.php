<?php
/**
 * Plugin Name:       Fast WordPress Media Cleaner
 * Description:      A WordPress plugin that efficiently marks your unused media files for deletion.
 * Version:           1.0.0
 * Author:            Tareq Monower
 * Author URI:        https://profiles.wordpress.org/tamimh/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fast-social-media-ai-poster
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('FAST_WORDPRESS_MEDIA_CLEANER_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 */
function fast_wordpress_media_cleaner_activate()
{
    // Require the activator class file
    require_once plugin_dir_path(__FILE__) . 'includes/class-fast-wordpress-media-cleaner-activator.php';
    // Activate the plugin
    Fast_Wordpress_Media_Cleaner_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function fast_wordpress_media_cleaner_deactivate()
{
    // Require the deactivator class file
    require_once plugin_dir_path(__FILE__) . 'includes/class-fast-wordpress-media-cleaner-deactivator.php';
    // Deactivate the plugin
    Fast_Wordpress_Media_Cleaner_Deactivator::deactivate();
}

// Register the activation and deactivation hooks
register_activation_hook(__FILE__, 'fast_wordpress_media_cleaner_activate');
register_deactivation_hook(__FILE__, 'fast_wordpress_media_cleaner_deactivate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-fast-wordpress-media-cleaner-main.php';




function enqueue_admin_assets($hook)
{
    // Enqueue styles in the WordPress admin menus
    if (in_array($hook, array('upload.php', 'media.php'))) {
        wp_enqueue_style(
            'fast-media-cleaner-style',
            plugin_dir_url(__FILE__) . 'assets/css/style.css',
            [],
            '1.0.0'
        );
    }

    // Enqueue scripts
    wp_enqueue_script(
        'fast-media-cleaner-script',
        plugin_dir_url(__FILE__) . 'assets/js/script.js',
        ['jquery'],
        '1.0.0',
        true
    );

    // Pass admin-ajax URL and nonce to script
    wp_localize_script('fast-media-cleaner-script', 'fastMediaCleaner', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'mark_unused_nonce' => wp_create_nonce('mark_unused_images'),
        'remove_marks_nonce' => wp_create_nonce('remove_marks'),
        'nonce' => wp_create_nonce('media_cleaner_nonce'),
    ]);
}

add_action('admin_enqueue_scripts', 'enqueue_admin_assets');



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
function run_fast_wordpress_media_cleaner()
{
    // Create an instance of the Fast_Wordpress_Media_Cleaner class
    $plugin = new Fast_Wordpress_Media_Cleaner_Wordpress_Plugin();
    // Run the plugin
    $plugin->run();
}
// Start the plugin
run_fast_wordpress_media_cleaner();