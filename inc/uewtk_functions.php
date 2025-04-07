<?php 


function uewtk_kses( $raw ) {
	$allowed_tags = array(
		'a'          => array(
			'class'  => array(),
			'href'   => array(),
			'rel'    => array(),
			'title'  => array(),
			'target' => array(),
		),
		'abbr'       => array(
			'title' => array(),
		),
		'b'          => array(),
		'blockquote' => array(
			'cite' => array(),
		),
		'cite'       => array(
			'title' => array(),
		),
		'code'       => array(),
		'pre'        => array(),
		'del'        => array(
			'datetime' => array(),
			'title'    => array(),
		),
		'dd'         => array(),
		'div'        => array(
			'class'                      => array(),
			'id'                         => array(),
			'title'                      => array(),
			'style'                      => array(),
			'data-template-source'       => array(),
			'data-xpro-widgetarea-key'   => array(),
			'data-xpro-widgetarea-index' => array(),
		),
		'dl'         => array(),
		'dt'         => array(),
		'em'         => array(),
		'strong'     => array(),
		'h1'         => array(
			'id'    => array(),
			'class' => array(),
		),
		'h2'         => array(
			'id'    => array(),
			'class' => array(),
		),
		'h3'         => array(
			'id'    => array(),
			'class' => array(),
		),
		'h4'         => array(
			'id'    => array(),
			'class' => array(),
		),
		'h5'         => array(
			'id'    => array(),
			'class' => array(),
		),
		'h6'         => array(
			'id'    => array(),
			'class' => array(),
		),
		'i'          => array(
			'id'          => array(),
			'class'       => array(),
			'title'       => array(),
			'aria-hidden' => array(),
		),
		'img'        => array(
			'alt'    => array(),
			'class'  => array(),
			'height' => array(),
			'src'    => array(),
			'width'  => array(),
		),
		'li'         => array(
			'class' => array(),
		),
		'ol'         => array(
			'class' => array(),
		),
		'p'          => array(
			'class' => array(),
		),
		'q'          => array(
			'cite'  => array(),
			'title' => array(),
		),
		'span'       => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'iframe'     => array(
			'width'       => array(),
			'height'      => array(),
			'scrolling'   => array(),
			'frameborder' => array(),
			'allow'       => array(),
			'src'         => array(),
			'id'          => array(),
			'class'       => array(),
		),
		'strike'     => array(),
		'br'         => array(),
		'table'      => array(),
		'thead'      => array(),
		'tbody'      => array(),
		'tfoot'      => array(),
		'tr'         => array(),
		'th'         => array(),
		'td'         => array(),
		'colgroup'   => array(),
		'col'        => array(),
		'ul'         => array(
			'class' => array(),
		),
		'svg'        => array(
			'class'           => true,
			'aria-hidden'     => true,
			'aria-labelledby' => true,
			'role'            => true,
			'xmlns'           => true,
			'width'           => true,
			'height'          => true,
			'viewbox'         => true, // <= Must be lower case!
		),
		'g'          => array( 'fill' => true ),
		'title'      => array( 'title' => true ),
		'path'       => array(
			'd'    => true,
			'fill' => true,
		),
		'style'      => array(
			'type' => array(),
		),
	);

	// Check for null before passing to wp_kses
	if ( null === $raw ) {
		return;
	}

	echo wp_kses( $raw, $allowed_tags );
}

/**
 * Retrieves a list of public post types that are shown in navigation menus,
 * excluding 'elementor_library' and 'attachment'.
 *
 * @return array An associative array of post types with their labels as values
 *               and their names as keys.
 */

 function uewtk_elementor_get_post_types(){
    $post_types = get_post_types( array( 
        'public' => true,
        'show_in_nav_menus' => true,
    ), 'objects' );
    $post_types = wp_list_pluck( $post_types, 'label', 'name' );
    unset($post_types['attachment']); // Only exclude attachment, keep elementor_library
    return $post_types;
}

/**
 * Retrieves a list of taxonomies that are shown in navigation menus.
 *
 * @param array  $args       Optional. An array of key => value arguments to match against the taxonomy objects.
 *                            Default empty array.
 * @param string $output      Optional. The type of output to return. Accepts either 'names', 'objects', or 'object types'.
 *                            Default 'object'.
 * @param bool   $list        Optional. Whether to return a list of taxonomy names or objects. Default true.
 * @param array  $diff_key    Optional. An array of taxonomy names to exclude from the list. Default empty array.
 *
 * @return array An associative array of taxonomy names (or objects) with their labels as values and their names as keys.
 */
function uewtk_elementor_get_taxonomies( $args = array(), $output = 'object', $list = true, $diff_key = array() ) {

	$taxonomies = get_taxonomies( $args, $output );
	if ( 'object' === $output && $list ) {
		$taxonomies = wp_list_pluck( $taxonomies, 'label', 'name' );
	}

	if ( ! empty( $diff_key ) ) {
		$taxonomies = array_diff_key( $taxonomies, $diff_key );
	}

	return $taxonomies;

}



/**
 * Retrieves a list of posts from a given post type, or all searchable post types if set to 'any',
 * and filters them by a search query if provided.
 *
 * @param string $post_type The post type to query. Default 'post'. Set to 'any' to query all searchable post types.
 * @param int    $limit     The number of results to return. Default -1, which returns all results. Set to 0 to return no results.
 * @param string $search    The search query to filter the results. Default empty.
 *
 * @return array An associative array of post titles with their IDs as keys.
 */
function uewtk_elementor_get_query_post_list( $post_type = 'post', $limit = - 1, $search = '' ) {

	global $wpdb;
	$where = '';
	$data  = array();

	if ( - 1 === $limit ) {
		$limit = '';
	} elseif ( 0 === $limit ) {
		$limit = 'limit 0,1';
	} else {
		$limit = $wpdb->prepare( ' limit 0,%d', esc_sql( $limit ) );
	}

	if ( 'any' === $post_type ) {
		$in_search_post_types = get_post_types( array( 'exclude_from_search' => false ) );
		if ( empty( $in_search_post_types ) ) {
			$where .= ' AND 1=0 ';
		} else {
			$where .= " AND {$wpdb->posts}.post_type IN ('" . join( "', '", array_map( 'esc_sql', $in_search_post_types ) ) . "')";
		}
	} elseif ( ! empty( $post_type ) ) {
		$where .= $wpdb->prepare( " AND {$wpdb->posts}.post_type = %s", esc_sql( $post_type ) );
	}

	if ( ! empty( $search ) ) {
		$where .= $wpdb->prepare( " AND {$wpdb->posts}.post_title LIKE %s", '%' . esc_sql( $search ) . '%' );
	}

	$results = $wpdb->get_results(
		sprintf( "select post_title,ID  from %s where post_status = 'publish' %s %s", $wpdb->posts, $where, $limit )  //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
	);

	if ( ! empty( $results ) ) {
		foreach ( $results as $row ) {
			$data[ $row->ID ] = $row->post_title;
		}
	}

	return $data;
}



/**
 * Retrieves a list of authors.
 *
 * Fetches all users from the database and returns an associative array
 * where the keys are user IDs and the values are the display names of the users.
 *
 * @return array An associative array of author display names with their IDs as keys.
 */

function uewtk_elementor_get_authors_list() {
	$users = get_users(
		array(
			'fields' => array(
				'ID',
				'display_name',
			),
		)
	);

	if ( ! empty( $users ) ) {
		return wp_list_pluck( $users, 'display_name', 'ID' );
	}

	return array();
}




/**
 * Retrieves an attachment by its ID.
 *
 * @param int $attachment_id Attachment ID.
 *
 * @return array An associative array with the attachment's data.
 */
function uewtk_elementor_get_attachment( $attachment_id ) {

	$attachment = get_post( $attachment_id );

	return array(
		'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption'     => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href'        => get_permalink( $attachment->ID ),
		'src'         => $attachment->guid,
		'title'       => $attachment->post_title,
	);
}


/**
 * Replaces special characters in a string with their corresponding HTML entities
 * and removes any unnecessary characters to make the string friendly for URL slugs.
 *
 * @param string $string The string to replace.
 *
 * @return string The modified string.
 */
function uewtk_elementor_friendly_str_replace( $string ) {
	$string = str_replace( array( '[\', \']' ), '', $string );
	$string = preg_replace( '/\[.*\]/U', '', $string );
	$string = preg_replace( '/&(amp;)?#?[a-z0-9]+;/i', '-', $string );
	$string = htmlentities( $string, ENT_COMPAT, 'utf-8' );
	$string = preg_replace(
		'/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i',
		'\\1',
		$string
	);
	$string = preg_replace( array( '/[^a-z0-9]/i', '/[-]+/' ), '-', $string );

	return strtolower( trim( $string, '-' ) );
}