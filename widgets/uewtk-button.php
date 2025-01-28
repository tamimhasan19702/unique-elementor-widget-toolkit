<?php
namespace UniqueElementorToolkit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Unique Button
 *
 * Elementor widget for Unique Button
 *
 * @since 1.0.0
 */
class Unique_Button extends Widget_Base {

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'unique-button';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Unique Button', 'unique-elementor-widget-toolkit' );
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'uewtk-phone-book';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'unique-elementor-widget-toolkit' ];
    }

    /**
     * Retrieve the list of scripts the widget depended on.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */

    protected function uewtk_cool_card_controls(){
        $this->start_controls_section(
            'uewtk_button_content',
            [
                'label' => __( 'Unique Button', 'unique-elementor-widget-toolkit' ),
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label' => __( 'Button Type', 'unique-elementor-widget-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __( 'Default', 'unique-elementor-widget-toolkit' ),
                    'outline' => __( 'Outline', 'unique-elementor-widget-toolkit' ),
                    'link' => __( 'Link', 'unique-elementor-widget-toolkit' ),
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'unique-elementor-widget-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Click Me!' , 'unique-elementor-widget-toolkit' ),
                'placeholder' => __( 'Click Me!' , 'unique-elementor-widget-toolkit' ),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => __( 'Button Link', 'unique-elementor-widget-toolkit' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'unique-elementor-widget-toolkit' ),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => __( 'Button Icon', 'unique-elementor-widget-toolkit' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => __( 'Icon Position', 'unique-elementor-widget-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => __( 'Left', 'unique-elementor-widget-toolkit' ),
                    'right' => __( 'Right', 'unique-elementor-widget-toolkit' ),
                ],
            ]
        );

        $this->add_control(
            'custom_button_id',
            [
                'label' => __( 'Custom Button ID', 'unique-elementor-widget-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __( 'Enter custom ID', 'unique-elementor-widget-toolkit' ),
            ]
        );

        $this->end_controls_section();
    }


    protected function uewtk_cool_card_styles(){
        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Style', 'unique-elementor-widget-toolkit' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        
        

        $this->end_controls_section();
    }

    public function get_style_depends(): array {
		return [ 'uewtk-button-css', 'uewtk-icons' ];
	}

    public function get_script_depends(): array {
        return [ 'uewtk-button-js' ];
    }


    /**
     * Register the widget controls.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls() {
       
        $this->uewtk_cool_card_controls();

        $this->uewtk_cool_card_styles();
        
    }

    /**
     * Render the widget output on the frontend.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings_for_display();
    
        ?>

<i class="icon-music"></i>


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



<?php 
    }
}