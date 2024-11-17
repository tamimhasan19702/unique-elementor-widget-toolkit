<?php
/**
 * Plugin Name:       Fast Social Media AI Poster
 * Description:       A WordPress plugin that generates custom social media posts for products by analyzing them with AI.
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

define('FAST_SOCIAL_MEDIA_AI_POSTER_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 */
function fast_social_media_ai_poster_activate()
{
    // Require the activator class file
    require_once plugin_dir_path(__FILE__) . 'includes/class-social-media-ai-poster-activator.php';
    // Activate the plugin
    Fast_Social_Media_Ai_Poster_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function fast_social_media_ai_poster_deactivate()
{
    // Require the deactivator class file
    require_once plugin_dir_path(__FILE__) . 'includes/class-social-media-ai-poster-deactivator.php';
    // Deactivate the plugin
    Fast_Social_Media_Ai_Poster_Deactivator::deactivate();
}

// Register the activation and deactivation hooks
register_activation_hook(__FILE__, 'fast_social_media_ai_poster_activate');
register_deactivation_hook(__FILE__, 'fast_social_media_ai_poster_deactivate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-social-media-ai-poster-main.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
function run_fast_social_media_ai_poster()
{
    // Create an instance of the Fast_Auto_Order_Complete class
    $plugin = new Fast_Social_Media_Ai_Poster();
    // Run the plugin
    $plugin->run();
}
// Start the plugin
run_fast_social_media_ai_poster();