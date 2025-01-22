<?php
namespace UniqueElementorToolkit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Unique Info Card
 *
 * Elementor widget for Unique Info Card
 *
 * @since 1.0.0
 */
class Unique_Info_Card extends Widget_Base {

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
        return 'unique-info-card';
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
        return __( 'Unique Info Card', 'unique-elementor-widget-toolkit' );
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
        return 'eicon-info-box';
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
            'section_content',
            [
                'label' => __( 'Content', 'unique-elementor-widget-toolkit' ),
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

        $this->add_control(
            'text_transform',
            [
                'label' => __( 'Text Transform', 'unique-elementor-widget-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __( 'None', 'unique-elementor-widget-toolkit' ),
                    'uppercase' => __( 'UPPERCASE', 'unique-elementor-widget-toolkit' ),
                    'lowercase' => __( 'lowercase', 'unique-elementor-widget-toolkit' ),
                    'capitalize' => __( 'Capitalize', 'unique-elementor-widget-toolkit' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'text-transform: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function get_style_depends(): array {
		return [ 'uewtk-cool-card' ];
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

<div class="card">
    <div class="card-content">
        <h1 class="card-titel">Lorem ipsum</h1>
        <p class="card-description">
            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
            nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,
            sed diam voluptua. At vero eos et accusam et justo duo dolores et ea
            rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem
            ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur
            sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et
            dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam
            et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea
            takimata sanctus est Lorem ipsum dolor sit amet.
        </p>
        <a class="card-button">Lorem </a>
    </div>
</div>



<?php 
    }
}