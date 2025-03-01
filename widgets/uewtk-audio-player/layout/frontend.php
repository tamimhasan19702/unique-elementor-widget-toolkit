<?php 

use Elementor\Icons_Manager;


// The type of HTML element to use as the button
$html_tag = ( $settings['link']['url'] ) ? 'a' : 'span';

// The HTML attributes to add to the element
$attr     = ( $settings['button_css_id'] ) ? ' id="' . $settings['button_css_id'] . '"' : '';
// Add the target attribute if the link is external
$attr    .= $settings['link']['is_external'] ? ' target="_blank"' : '';
// Add the rel attribute if the link is nofollow
$attr    .= $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
// Add the href attribute if the link has a URL
$attr    .= $settings['link']['url'] ? ' href="' . $settings['link']['url'] . '"' : '';


$hover_animation = ( '2d-transition' === $settings['hover_animation'] ) ? 'uewtk-button-2d-animation ' . $settings['hover_2d_css_animation'] : ( ( 'background-transition' === $settings['hover_animation'] ) ? 'uewtk-button-bg-animation ' . $settings['hover_background_css_animation'] : ( ( 'unique' === $settings['hover_animation'] ) ? 'uewtk-elementor-button-hover-style-' . $settings['hover_unique_animation'] : 'uewtk-elementor-button-animation-none' ) );


?>


<<?php echo esc_attr( $html_tag ); ?> <?php uewtk_kses( $attr ); ?>
    class="uewtk-elementor-button <?php echo esc_attr( $hover_animation ); ?> uewtk-align-icon-<?php echo ( 'left' === $settings['icon_align'] ) ? 'left' : 'right'; ?>">
    <span class="uewtk-elementor-button-inner">
        <?php if ( $settings['icon']['value'] ) { ?>
        <span
            class="uewtk-elementor-button-media"><?php Icons_Manager::render_icon( $settings['icon'], array( 'aria-hidden' => 'true' ) ); ?></span>
        <?php } ?>
        <span class="uewtk-button-text"><?php echo esc_html( $settings['text'] ); ?></span>
    </span>
</<?php echo esc_attr( $html_tag ); ?>>