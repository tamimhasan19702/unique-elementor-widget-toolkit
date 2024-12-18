<?php 

class Fast_Wordpress_Media_Cleaner_Wordpress_Plugin
{
    public function run()
    {
        add_action('restrict_manage_posts', array($this, 'add_media_management_buttons'));
        add_action('load-upload.php', array($this, 'show_buttons_in_media_library'));
       
        add_action('wp_ajax_mark_unused_images', array($this, 'mark_unused_images_ajax_handler')); 
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

   
   
    function mark_unused_images_ajax_handler() {
        check_ajax_referer('mark_unused_images_action', 'security');
    
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'You do not have sufficient permissions.']);
        }
    
        global $wpdb;
    
        $used_images = []; // Initialize array to track used images
        $unused_count = 0; // Counter for unused images
        $used_count = 0;   // Counter for used images
        $unused_image_ids = []; // Array to store IDs of unused images
    
        // Define IDs to include (site logo and favicon)
        $site_logo_id = get_theme_mod('custom_logo');
        $site_icon_id = get_option('site_icon');
        $ids_to_include = array_filter([$site_logo_id, $site_icon_id]);
    
        foreach ($ids_to_include as $id) {
            $url = untrailingslashit(esc_url_raw(wp_get_attachment_url($id)));
            if ($url) $used_images[] = $url;
        }
    
        // WooCommerce images
        if (class_exists('WooCommerce')) {
            $products = wc_get_products(['limit' => -1]);
            foreach ($products as $product) {
                $used_images[] = untrailingslashit(esc_url_raw(wp_get_attachment_url(get_post_thumbnail_id($product->get_id()))));
                $gallery_image_ids = $product->get_gallery_image_ids();
                foreach ($gallery_image_ids as $id) {
                    $used_images[] = untrailingslashit(esc_url_raw(wp_get_attachment_url($id)));
                }
            }
        }
    
        // Posts and Pages including drafts and private posts
        $posts = $wpdb->get_results("SELECT ID, post_content FROM $wpdb->posts WHERE post_status IN ('publish', 'draft', 'private')", ARRAY_A);
        foreach ($posts as $post) {
            preg_match_all('/https?:\/\/[^\s"]+\.(jpg|jpeg|png|gif|webp)/i', $post['post_content'], $matches);
            if (!empty($matches[0])) $used_images = array_merge($used_images, $matches[0]); // Fixed line
    
            $thumbnail_id = get_post_thumbnail_id($post['ID']);
            if ($thumbnail_id) {
                $used_images[] = untrailingslashit(esc_url_raw(wp_get_attachment_url($thumbnail_id)));
            }
    
            // Elementor data in meta fields
            $meta_fields = $wpdb->get_results($wpdb->prepare(
                "SELECT meta_value FROM $wpdb->postmeta WHERE post_id = %d",
                $post['ID']
            ), ARRAY_A);
    
            foreach ($meta_fields as $meta) {
                $meta_data = maybe_unserialize($meta['meta_value']);
                if (is_string($meta_data) && json_decode($meta_data, true)) {
                    $decoded_data = json_decode($meta_data, true);
                    $used_images = array_merge($used_images, extract_image_urls_from_elementor_data($decoded_data));
                }
            }
        }
    
        // Post Categories and Product Categories
        $taxonomies = ['category', 'product_cat'];
        foreach ($taxonomies as $taxonomy) {
            $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);
            foreach ($terms as $term) {
                $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                if ($thumbnail_id) {
                    $used_images[] = untrailingslashit(esc_url_raw(wp_get_attachment_url($thumbnail_id)));
                }
            }
        }
    
        // Mark unused images in Media Library
        $media_query = new WP_Query([
            'post_type'      => 'attachment',
            'post_status'    => 'inherit',
            'post_mime_type' => 'image',
            'posts_per_page' => -1,
        ]);
    
        if ($media_query->have_posts()) {
            while ($media_query->have_posts()) {
                $media_query->the_post();
     $media_id = get_the_ID();
                $media_url = untrailingslashit(esc_url_raw(wp_get_attachment_url($media_id)));
                $current_title = get_the_title($media_id);
    
                if (!in_array($media_url, $used_images)) {
                    if (strpos($current_title, 'Delete_') !== 0) {
                        wp_update_post(['ID' => $media_id, 'post_title' => "Delete_" . $current_title]);
                        $unused_count++;
                        $unused_image_ids[] = $media_id; // Store the ID of the unused image
                    }
                } else {
                    $used_count++;
                }
            }
        }
    
        wp_reset_postdata();
    
        wp_send_json_success([
            'message'       => 'Image analysis complete.',
            'used_count'    => $used_count,
            'unused_count'   => $unused_count,
            'unused_image_ids' => $unused_image_ids, // Return the IDs of unused images
        ]);
    }
   
    
}