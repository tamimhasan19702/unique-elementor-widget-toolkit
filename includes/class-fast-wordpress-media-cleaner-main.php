<?php
class Fast_Wordpress_Media_Cleaner_Wordpress_Plugin
{
    public function run()
    {

        add_action('restrict_manage_posts', array($this, 'add_media_management_buttons'));
        add_action('load-upload.php', array($this, 'show_buttons_in_media_library'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

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
        ?>
<div class="alignright actions">
    <button class="fwmc-button fwmc-button-primary" id="mark-unused-images-button">Mark Unused Images</button>
    <button class="fwmc-button fwmc-button-secondary" id="remove-marks-button">Remove Marks</button>
    <button class="fwmc-button fwmc-button-danger" id="delete-selected-button">Delete Selected</button>
    <button class="fwmc-button fwmc-button-info" id="export-data-button">Export Data</button>
</div>
<?php 


    }

    // Ensure buttons only appear in the Media Library
    public function show_buttons_in_media_library()
    {
        global $mode;
        if (get_current_screen()->post_type !== 'attachment') {
            remove_action('restrict_manage_posts', array($this, 'add_media_management_buttons'));
        }
    }

    public function enqueue_scripts()
{
    wp_enqueue_script('fwmc-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
}


}