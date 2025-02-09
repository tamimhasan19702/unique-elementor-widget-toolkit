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