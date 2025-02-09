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
			'button_text',
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