<?php 


use Elementor\Group_Control_Image_Size;

$before_image_url = Group_Control_Image_Size::get_attachment_image_src( $settings['before_image']['id'], 'before_thumbnail', $settings );
		$after_image_url = Group_Control_Image_Size::get_attachment_image_src( $settings['after_image']['id'], 'after_thumbnail', $settings );
		
		// Classes
		$wrapper_classes = [
			'uewtk-compare-wrapper',
			'uewtk-compare-handle-' . $settings['display_handle'],
			'uewtk-compare-label-' . $settings['display_label'],
			$settings['mouse_move'] ? 'uewtk-compare-move-on-hover' : '',
			$settings['wiggle'] ? 'uewtk-compare-wiggle' : '',
		];

?>


<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>">
    <div class="uewtk-compare-wrapper uewtk-compare-<?php echo esc_attr( $settings['orientation'] ); ?>">
        <div class="uewtk-compare-item uewtk-compare-container"
            style="height: <?php echo esc_attr( $settings['visible_ratio']['size'] ); ?>%">
            <!-- Before Image -->
            <img fetchpriority="high" decoding="async" src="<?php echo esc_url( $before_image_url ); ?>"
                class="attachment-large size-large uewtk-compare-before"
                alt="<?php echo esc_attr( $settings['before_label'] ); ?>"
                style="clip: rect(0px, <?php echo esc_attr( $settings['visible_ratio']['size'] ); ?>%, 500px, 0px);">

            <!-- After Image -->
            <img decoding="async" src="<?php echo esc_url( $after_image_url ); ?>"
                class="attachment-large size-large uewtk-compare-after"
                alt="<?php echo esc_attr( $settings['after_label'] ); ?>">

            <!-- Labels -->
            <div class="uewtk-compare-overlay">
                <?php if( $settings['before_label'] ) : ?>
                <div class="uewtk-compare-before-label">
                    <?php echo esc_html( $settings['before_label'] ); ?>
                </div>
                <?php endif; ?>

                <?php if( $settings['after_label'] ) : ?>
                <div class="uewtk-compare-after-label">
                    <?php echo esc_html( $settings['after_label'] ); ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Handle -->
            <div class="uewtk-compare-handle"
                data-wiggle-timeout="<?php echo esc_attr( $settings['wiggle_timeout']['size'] ); ?>"
                style="left: <?php echo esc_attr( $settings['visible_ratio']['size'] ); ?>%">
                <span class="uewtk-compare-left-arrow"></span>
                <span class="uewtk-compare-right-arrow"></span>
            </div>
        </div>
    </div>
</div>