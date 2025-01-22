<?php
namespace UniqueElementorToolkit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Unique Hero Slider
 *
 * Elementor widget for Unique Hero Slider
 *
 * @since 1.0.0
 */
class Unique_Hero_Slider extends Widget_Base {

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
        return 'unique-hero-slider';
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
        return __( 'Unique Hero Slider', 'unique-elementor-widget-toolkit' );
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
		return [ 'uewtk-hero-slider-css' ];
	}


    /**
     * Retrieve the list of script dependencies the widget depends on.
     *
     * Used to set script dependencies required to run the widget's code.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget script dependencies.
     */
    public function get_script_depends() {
        return [ 'uewtk-hero-slider-js']; // Add the model-viewer script as a dependency
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

<section class="unique-section">
    <div class="unique-main">
        <ul class="unique-slider">
            <li class="unique-item" style="
              background-image: url(&quot;https://cdn.mos.cms.futurecdn.net/dP3N4qnEZ4tCTCLq59iysd.jpg&quot;);
            ">
                <div class="unique-content">
                    <h2 class="unique-title">"Lossless Youths"</h2>
                    <p class="unique-description">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Tempore fuga voluptatum, iure corporis inventore praesentium
                        nisi. Id laboriosam ipsam enim.
                    </p>
                    <button>Read More</button>
                </div>
            </li>
            <li class="unique-item" style="
              background-image: url(&quot;https://i.redd.it/tc0aqpv92pn21.jpg&quot;);
            ">
                <div class="unique-content">
                    <h2 class="unique-title">"Estrange Bond"</h2>
                    <p class="unique-description">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Tempore fuga voluptatum, iure corporis inventore praesentium
                        nisi. Id laboriosam ipsam enim.
                    </p>
                    <button>Read More</button>
                </div>
            </li>
            <li class="unique-item" style="
              background-image: url(&quot;https://wharferj.files.wordpress.com/2015/11/bio_north.jpg&quot;);
            ">
                <div class="unique-content">
                    <h2 class="unique-title">"The Gate Keeper"</h2>
                    <p class="unique-description">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Tempore fuga voluptatum, iure corporis inventore praesentium
                        nisi. Id laboriosam ipsam enim.
                    </p>
                    <button>Read More</button>
                </div>
            </li>
            <li class="unique-item" style="
              background-image: url(&quot;https://images7.alphacoders.com/878/878663.jpg&quot;);
            ">
                <div class="unique-content">
                    <h2 class="unique-title">"Last Trace Of Us"</h2>
                    <p class="unique-description">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Tempore fuga voluptatum, iure corporis inventore praesentium
                        nisi. Id laboriosam ipsam enim.
                    </p>
                    <button>Read More</button>
                </div>
            </li>
            <li class="unique-item" style="
              background-image: url(&quot;https://theawesomer.com/photos/2017/07/simon_stalenhag_the_electric_state_6.jpg&quot;);
            ">
                <div class="unique-content">
                    <h2 class="unique-title">"Urban Decay"</h2>
                    <p class="unique-description">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Tempore fuga voluptatum, iure corporis inventore praesentium
                        nisi. Id laboriosam ipsam enim.
                    </p>
                    <button>Read More</button>
                </div>
            </li>
            <li class="unique-item" style="
              background-image: url(&quot;https://da.se/app/uploads/2015/09/simon-december1994.jpg&quot;);
            ">
                <div class="unique-content">
                    <h2 class="unique-title">"The Migration"</h2>
                    <p class="unique-description">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Tempore fuga voluptatum, iure corporis inventore praesentium
                        nisi. Id laboriosam ipsam enim.
                    </p>
                    <button>Read More</button>
                </div>
            </li>
        </ul>
        <nav class="unique-nav">
            <ion-icon class="unique-btn unique-prev" name="arrow-back-outline"></ion-icon>
            <ion-icon class="unique-btn unique-next" name="arrow-forward-outline"></ion-icon>
        </nav>
    </div>
</section>



<?php 
    }
}