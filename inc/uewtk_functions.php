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
	$post_types = get_post_types( array( 'public' => true,
'show_in_nav_menus' => true,
), 'objects' );



$post_types = wp_list_pluck( $post_types, 'label', 'name' );

return array_diff_keys( $post_types, array( 'elementor_library', 'attachment') );

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