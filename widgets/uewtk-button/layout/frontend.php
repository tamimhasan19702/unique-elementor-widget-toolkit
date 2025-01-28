<?php 

?>


<button class="bubbly-button" id="<?php echo $settings['custom_button_id']; ?>"
    data-type="<?php echo $settings['button_type']; ?>">

    <?php if($settings['icon_position'] == 'left') : ?>
    <span
        class="button-icon icon-left"><?php \Elementor\Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']); ?></span>
    <?php endif; ?>

    <?php echo $settings['button_text']; ?>

    <?php if($settings['icon_position'] == 'right') : ?>
    <span
        class="button-icon icon-right"><?php \Elementor\Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']); ?></span>
    <?php endif; ?>
</button>