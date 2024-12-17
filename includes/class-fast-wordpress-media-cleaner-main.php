<?php 

class Fast_Wordpress_Media_Cleaner_Wordpress_Plugin
{
    public function run()
    {
        add_action('restrict_manage_posts', array($this, 'add_media_management_buttons'));
        add_action('load-upload.php', array($this, 'show_buttons_in_media_library'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_footer', array($this, 'display_unused_media')); // Hook to display unused media
    }

    // Add the buttons to the Media Library toolbar
    public function add_media_management_buttons()
    {
        // Only show for users with proper permissions
        if (!current_user_can('manage_options')) {
            return;
        }

        // Display buttons in the Media Library
        ?>
<div class="alignright actions">
    <button class="fwmc-button fwmc-button-primary" id="mark-unused-images-button">Mark Unused Images</button>
    <button class="fwmc-button fwmc-button-secondary" id="remove-marks-button">Remove Marks</button>
    <button class="fwmc-button fwmc-button-danger" id="delete-selected-button">Delete Selected</button>
    <button class="fwmc-button fwmc-button-info" id="export-data-button">Export Data</button>
    <button class="fwmc-button fwmc-button-warning" id="show-unused-media-button">Show Unused Media</button>
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

    public function custom_query_unused_media()
    {
        global $wpdb;

        $results = $wpdb->get_results(
            "SELECT p1.ID, p1.post_title 
            FROM {$wpdb->posts} p1 
            WHERE p1.post_type = 'attachment' 
            AND p1.post_mime_type LIKE 'image%' 
            AND NOT EXISTS ( 
                SELECT 1 
                FROM {$wpdb->posts} p2 
                WHERE p2.post_status = 'publish' 
                AND p2.post_content LIKE CONCAT('%', p1.guid, '%') 
            )"
        );

        return $results;
    }

    // Display unused media files
    public function display_unused_media()
    {
        if (isset($_POST['show_unused_media'])) {
            $unused_media = $this->custom_query_unused_media();
            echo '<div class="notice notice-info is-dismissible">';
            echo '<h2>Unused Media Files</h2>';
            echo '<pre>';
            var_dump($unused_media);
            echo '</pre>';
            echo '</div>';
        }
    }
}