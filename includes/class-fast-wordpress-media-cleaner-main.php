<?php
class Fast_Wordpress_Media_Cleaner_Wordpress_Plugin
{
    public function run()
    {

        add_action('restrict_manage_posts', array($this, 'add_media_management_buttons'));
        add_action('load-upload.php', array($this, 'show_buttons_in_media_library'));
    }

    // Enqueue script and style


    // Add the buttons to the Media Library toolbar
    public function add_media_management_buttons()
    {
        // Only show for users with proper permissions
        if (!current_user_can('manage_options')) {
            return;
        }

        // Display buttons in the Media Library

        // Updated buttons with proper classes for spacing and padding
        include_once(dirname(__FILE__, 2) . '/assets/view/media-buttons.php');


    }

    // Ensure buttons only appear in the Media Library
    public function show_buttons_in_media_library()
    {
        global $mode;
        if (get_current_screen()->post_type !== 'attachment') {
            remove_action('restrict_manage_posts', array($this, 'add_media_management_buttons'));
        }
    }


    public function mark_unused_attachments()
    {

    }
}