<?php
class Fast_Wordpress_Media_Cleaner_Wordpress_Plugin
{
    public function run()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('restrict_manage_posts', array($this, 'add_media_management_buttons'));
        add_action('load-upload.php', array($this, 'show_buttons_in_media_library'));
    }

    // Enqueue script and style
    public function enqueue_admin_assets($hook)
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
        ]);
    }

    // Add the buttons to the Media Library toolbar
    public function add_media_management_buttons()
    {
        // Only show for users with proper permissions
        if (!current_user_can('manage_options')) {
            return;
        }

        // Display buttons in the Media Library
        echo '<div class="alignright actions">';
        echo '<button class="fwmc-button fwmc-button-primary" id="mark-unused-images-button">Mark Unused Images</button>';
        echo '<button class="fwmc-button fwmc-button-secondary" id="remove-marks-button">Remove Marks</button>';
        echo '</div>';
    }

    // Ensure buttons only appear in the Media Library
    public function show_buttons_in_media_library()
    {
        error_log('Post type: ' . get_current_screen()->post_type);
        if (get_current_screen()->post_type !== 'attachment') {
            remove_action('restrict_manage_posts', array($this, 'add_media_management_buttons'));
        }
    }
    
}