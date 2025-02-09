<?php
namespace UniqueElementorToolkit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;


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
        return 'eicon-button uewtk-label';
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
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_keywords() {
		return array( 'button', 'unique', 'cta', 'link' );
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

    protected function uewtk_button_controls(){
        $this->start_controls_section(
            'section_general',
            [
                'label' => __( 'General', 'unique-elementor-widget-toolkit' ),
            ]
        );

        $this->add_control(
			'button_type',
			array(
				'label' => __( 'Button Type', 'unique-elementor-widget-toolkit' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'button' => __( 'Button', 'unique-elementor-widget-toolkit' ),
					'link' => __( 'Link', 'unique-elementor-widget-toolkit' ),
				],
				'default' => 'button',
			)
		);

        $this->add_control(
			'text',
			array(
				'label'       => __( 'Button Text', 'unique-elementor-widget-toolkit' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => __( 'Click here', 'unique-elementor-widget-toolkit' ),
				'placeholder' => __( 'Click here', 'unique-elementor-widget-toolkit' ),
			)
		);

        $this->add_control(
			'link',
			array(
				'label'       => __( 'Link', 'unique-elementor-widget-toolkit' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => __( 'https://your-link.com', 'unique-elementor-widget-toolkit' ),
				'default'     => array(
					'url' => '#',
				),
			)
		);

        $this->add_responsive_control(
			'align',
			array(
				'label'        => __( 'Alignment', 'unique-elementor-widget-toolkit' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => array(
					'left'    => array(
						'title' => __( 'Left', 'unique-elementor-widget-toolkit' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'unique-elementor-widget-toolkit' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'unique-elementor-widget-toolkit' ),
						'icon'  => 'eicon-h-align-right',
					),
					'justify' => array(
						'title' => __( 'Justified', 'unique-elementor-widget-toolkit' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
			)
		);

        $this->add_control(
			'icon',
			array(
				'label'       => __( 'Icon', 'unique-elementor-widget-toolkit' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
			)
		);

        $this->add_control(
			'icon_align',
			array(
				'label'     => __( 'Icon Position', 'unique-elementor-widget-toolkit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => array(
					'left'  => __( 'Before', 'unique-elementor-widget-toolkit' ),
					'right' => __( 'After', 'unique-elementor-widget-toolkit' ),
				),
				'condition' => array(
					'icon[value]!' => '',
				),
			)
		);
      

        $this->add_responsive_control(
			'icon_indent',
			array(
				'label'     => __( 'Icon Spacing', 'unique-elementor-widget-toolkit' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .xpro-align-icon-right .xpro-elementor-button-media' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xpro-align-icon-left .xpro-elementor-button-media'  => 'margin-right: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'icon[value]!' => '',
				),
			)
		);

        $this->add_control(
			'button_css_id',
			array(
				'label'       => __( 'Button ID', 'unique-elementor-widget-toolkit' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => '',
				'title'       => __( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'unique-elementor-widget-toolkit' ),
				'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'unique-elementor-widget-toolkit' ),
				'separator'   => 'before',

			)
		);

		$this->add_control(
			'onclick_event',
			array(
				'label'       => esc_html__( 'onClick Event', 'unique-elementor-widget-toolkit' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'myFunction()',
			)
		);

        $this->end_controls_section();
    }


    protected function uewtk_button_styles(){

        $this->start_controls_section(
			'section_style',
			array(
				'label' => __( 'General', 'unique-elementor-widget-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);


        $this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				),
				'selector' => '{{WRAPPER}} .uewtk-elementor-button',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'text_shadow',
				'selector' => '{{WRAPPER}} .uewtk-elementor-button',
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => __( 'Normal', 'unique-elementor-widget-toolkit' ),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => __( 'Text Color', 'unique-elementor-widget-toolkit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .uewtk-elementor-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .uewtk-elementor-button svg' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'background',
				'label'    => __( 'Background', 'unique-elementor-widget-toolkit' ),
				'types'    => array( 'classic', 'gradient' ),
				'exclude'  => array( 'image' ),
				'selector' => '{{WRAPPER}} .uewtk-elementor-button,{{WRAPPER}} .uewtk-elementor-button-hover-style-skewFill:before,
								{{WRAPPER}} .uewtk-elementor-button-hover-style-flipSlide::before',
			)
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => __( 'Hover', 'unique-elementor-widget-toolkit' ),
			)
		);

		$this->add_control(
			'hover_color',
			array(
				'label'     => __( 'Text Color', 'unique-elementor-widget-toolkit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .uewtk-elementor-button:hover, {{WRAPPER}} .uewtk-elementor-button:focus'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .uewtk-elementor-button:hover svg, {{WRAPPER}} .uewtk-elementor-button:focus svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'button_background_hover',
				'label'    => __( 'Background', 'unique-elementor-widget-toolkit' ),
				'types'    => array( 'classic', 'gradient' ),
				'exclude'  => array( 'image' ),
				'selector' => '{{WRAPPER}} .uewtk-elementor-button-animation-none:hover,{{WRAPPER}} .uewtk-button-2d-animation:hover,
								{{WRAPPER}} .uewtk-button-bg-animation::before,{{WRAPPER}} .uewtk-elementor-button-hover-style-bubbleFromDown::before,
								{{WRAPPER}} .uewtk-elementor-button-hover-style-bubbleFromDown::after,{{WRAPPER}} .uewtk-elementor-button-hover-style-bubbleFromCenter::before,
								{{WRAPPER}} .uewtk-elementor-button-hover-style-bubbleFromCenter::after,{{WRAPPER}} .uewtk-elementor-button-hover-style-flipSlide,
								{{WRAPPER}} [class*=uewtk-elementor-button-hover-style-underline]:hover,{{WRAPPER}} .uewtk-elementor-button-hover-style-skewFill,
								
								{{WRAPPER}} .uewtk-elementor-button-animation-none:focus,{{WRAPPER}} .uewtk-button-2d-animation:focus,
								{{WRAPPER}} [class*=uewtk-elementor-button-focus-style-underline]:focus',
			)
		);


		$this->add_control(
			'button_hover_border_color',
			array(
				'label'     => __( 'Border Color', 'unique-elementor-widget-toolkit' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'border_border!'          => '',
					'hover_unique_animation!' => array(
						'underlineFromLeft',
						'underlineFromRight',
						'underlineFromCenter',
						'underlineReveal',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .uewtk-elementor-button:hover, {{WRAPPER}} .uewtk-elementor-button:focus' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_underline',
			array(
				'label'     => __( 'Line Color', 'unique-elementor-widget-toolkit' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'hover_animation'        => 'unique',
					'hover_unique_animation' => array(
						'underlineFromLeft',
						'underlineFromRight',
						'underlineFromCenter',
						'underlineReveal',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} [class*=uewtk-elementor-button-hover-style-underline]:before' => 'background-color: {{VALUE}};',
				),
			)
		);


		$this->add_control(
			'hover_animation',
			array(
				'label'   => __( 'Hover Animation', 'unique-elementor-widget-toolkit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => array(
					'none'                  => __( 'None', 'unique-elementor-widget-toolkit' ),
					'2d-transition'         => __( '2D', 'unique-elementor-widget-toolkit' ),
					'background-transition' => __( 'Background', 'unique-elementor-widget-toolkit' ),
					'unique'                => __( 'Unique', 'unique-elementor-widget-toolkit' ),
				),
			)
		);

		$this->add_control(
			'hover_2d_css_animation',
			array(
				'label'     => __( 'Animation Type', 'unique-elementor-widget-toolkit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'hvr-grow',
				'options'   => array(
					'hvr-grow'                   => __( 'Grow', 'unique-elementor-widget-toolkit' ),
					'hvr-shrink'                 => __( 'Shrink', 'unique-elementor-widget-toolkit' ),
					'hvr-pulse'                  => __( 'Pulse', 'unique-elementor-widget-toolkit' ),
					'hvr-pulse-grow'             => __( 'Pulse Grow', 'unique-elementor-widget-toolkit' ),
					'hvr-pulse-shrink'           => __( 'Pulse Shrink', 'unique-elementor-widget-toolkit' ),
					'hvr-push'                   => __( 'Push', 'unique-elementor-widget-toolkit' ),
					'hvr-pop'                    => __( 'Pop', 'unique-elementor-widget-toolkit' ),
					'hvr-bounce-in'              => __( 'Bounce In', 'unique-elementor-widget-toolkit' ),
					'hvr-bounce-out'             => __( 'Bounce Out', 'unique-elementor-widget-toolkit' ),
					'hvr-rotate'                 => __( 'Rotate', 'unique-elementor-widget-toolkit' ),
					'hvr-grow-rotate'            => __( 'Grow Rotate', 'unique-elementor-widget-toolkit' ),
					'hvr-float'                  => __( 'Float', 'unique-elementor-widget-toolkit' ),
					'hvr-sink'                   => __( 'Sink', 'unique-elementor-widget-toolkit' ),
					'hvr-bob'                    => __( 'Bob', 'unique-elementor-widget-toolkit' ),
					'hvr-hang'                   => __( 'Hang', 'unique-elementor-widget-toolkit' ),
					'hvr-wobble-vertical'        => __( 'Wobble Vertical', 'unique-elementor-widget-toolkit' ),
					'hvr-wobble-horizontal'      => __( 'Wobble Horizontal', 'unique-elementor-widget-toolkit' ),
					'hvr-wobble-to-bottom-right' => __( 'Wobble To Bottom Right', 'unique-elementor-widget-toolkit' ),
					'hvr-wobble-to-top-right'    => __( 'Wobble To Top Right', 'unique-elementor-widget-toolkit' ),
					'hvr-buzz'                   => __( 'Buzz', 'unique-elementor-widget-toolkit' ),
					'hvr-buzz-out'               => __( 'Buzz Out', 'unique-elementor-widget-toolkit' ),
				),
				'condition' => array(
					'hover_animation' => '2d-transition',
				),
			)
		);


		$this->add_control(
			'hover_background_css_animation',
			array(
				'label'     => __( 'Animation', 'unique-elementor-widget-toolkit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'hvr-sweep-to-right',
				'options'   => array(
					'hvr-sweep-to-right'         => __( 'Sweep To Right', 'unique-elementor-widget-toolkit' ),
					'hvr-sweep-to-left'          => __( 'Sweep To Left', 'unique-elementor-widget-toolkit' ),
					'hvr-sweep-to-bottom'        => __( 'Sweep To Bottom', 'unique-elementor-widget-toolkit' ),
					'hvr-sweep-to-top'           => __( 'Sweep To Top', 'unique-elementor-widget-toolkit' ),
					'hvr-bounce-to-right'        => __( 'Bounce To Right', 'unique-elementor-widget-toolkit' ),
					'hvr-bounce-to-left'         => __( 'Bounce To Left', 'unique-elementor-widget-toolkit' ),
					'hvr-bounce-to-bottom'       => __( 'Bounce To Bottom', 'unique-elementor-widget-toolkit' ),
					'hvr-bounce-to-top'          => __( 'Bounce To Top', 'unique-elementor-widget-toolkit' ),
					'hvr-radial-out'             => __( 'Radial Out', 'unique-elementor-widget-toolkit' ),
					'hvr-radial-in'              => __( 'Radial In', 'unique-elementor-widget-toolkit' ),
					'hvr-rectangle-in'           => __( 'Rectangle In', 'unique-elementor-widget-toolkit' ),
					'hvr-rectangle-out'          => __( 'Rectangle Out', 'unique-elementor-widget-toolkit' ),
					'hvr-shutter-in-horizontal'  => __( 'Shutter In Horizontal', 'unique-elementor-widget-toolkit' ),
					'hvr-shutter-out-horizontal' => __( 'Shutter Out Horizontal', 'unique-elementor-widget-toolkit' ),
					'hvr-shutter-in-vertical'    => __( 'Shutter In Vertical', 'unique-elementor-widget-toolkit' ),
					'hvr-shutter-out-vertical'   => __( 'Shutter Out Vertical', 'unique-elementor-widget-toolkit' ),
				),
				'condition' => array(
					'hover_animation' => 'background-transition',
				),
			)
		);

		$this->add_control(
			'hover_unique_animation',
			array(
				'label'     => __( 'Animation', 'unique-elementor-widget-toolkit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'skewFill',
				'options'   => array(
					'underlineFromLeft'   => __( 'Underline From Left', 'unique-elementor-widget-toolkit' ),
					'underlineFromRight'  => __( 'Underline From Right', 'unique-elementor-widget-toolkit' ),
					'underlineFromCenter' => __( 'Underline From Center', 'unique-elementor-widget-toolkit' ),
					'skewFill'            => __( 'Skew Fill', 'unique-elementor-widget-toolkit' ),
					'flipSlide'           => __( 'Flip Slide', 'unique-elementor-widget-toolkit' ),
					'bubbleFromDown'      => __( 'Bubble From Down', 'unique-elementor-widget-toolkit' ),
					'bubbleFromCenter'    => __( 'Bubble From Center', 'unique-elementor-widget-toolkit' ),
				),
				'condition' => array(
					'hover_animation' => 'unique',
				),
			)
		);

		$this->end_controls_tab();


		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'border',
				'selector'  => '{{WRAPPER}} .unique-elementor-button',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'border_radius',
			array(
				'label'      => __( 'Border Radius', 'unique-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .unique-elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .unique-elementor-button',
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => __( 'Padding', 'unique-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .unique-elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();


        

        $this->end_controls_section();
    }

    public function get_style_depends(): array {
		return [ 'uewtk-button-css', 'uewtk-icons' ,'uewtk-editor-style', 'uewtk-hover-effect' ];
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
       
        $this->uewtk_button_controls();

        $this->uewtk_button_styles();
        
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
        include UEWTK_WIDGETS . 'uewtk-button/layout/frontend.php';
    }
}