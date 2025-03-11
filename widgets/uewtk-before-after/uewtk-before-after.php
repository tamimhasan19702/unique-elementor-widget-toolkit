<?php
namespace UniqueElementorToolkit\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Unique Before_After
 *
 * Elementor widget for Unique Before_After
 *
 * @since 1.0.0
 */
class Unique_Before_After extends Widget_Base {

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
        return 'unique-before-after';
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
        return __( 'Unique Before After', 'unique-elementor-widget-toolkit' );
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
        return 'eicon-image-before-after uewtk-label';
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
		return array( 'before-after', 'unique', 'cta', 'link' );
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

    protected function uewtk_before_after_controls(){
        $this->start_controls_section(
			'section_before',
			array(
				'label' => __( 'Before', 'unique-elementor-widget-toolkit' ),
			)
		);

		$this->add_control(
			'before_label',
			array(
				'label'       => __( 'Label', 'unique-elementor-widget-toolkit' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => __( 'Before', 'unique-elementor-widget-toolkit' ),
				'placeholder' => __( 'Before Text Here', 'unique-elementor-widget-toolkit' ),
			)
		);

		$this->add_control(
			'before_image',
			array(
				'label'   => __( 'Choose Image', 'unique-elementor-widget-toolkit' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => array(
					'active' => true,
				),
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'before_thumbnail',
				'default'   => 'large',
				'separator' => 'none',
				'exclude'   => array(
					'custom',
				),
			)
		);

		$this->end_controls_section();


		//After
		$this->start_controls_section(
			'section_after',
			array(
				'label' => __( 'After', 'unique-elementor-widget-toolkit' ),
			)
		);

		$this->add_control(
			'after_label',
			array(
				'label'       => __( 'Label', 'unique-elementor-widget-toolkit' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => __( 'After', 'unique-elementor-widget-toolkit' ),
				'placeholder' => __( 'After Text Here', 'unique-elementor-widget-toolkit' ),
			)
		);

		$this->add_control(
			'after_image',
			array(
				'label'   => __( 'Choose Image', 'unique-elementor-widget-toolkit' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => array(
					'active' => true,
				),
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'after_thumbnail',
				'default'   => 'large',
				'separator' => 'none',
				'exclude'   => array(
					'custom',
				),
			)
		);

		$this->end_controls_section();

		//Settings
		$this->start_controls_section(
			'section_settings',
			array(
				'label' => __( 'Settings', 'unique-elementor-widget-toolkit' ),
			)
		);

		$this->add_control(
			'orientation',
			array(
				'label'              => __( 'Orientation', 'unique-elementor-widget-toolkit' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => array(
					'horizontal'  => __( 'Horizontal', 'unique-elementor-widget-toolkit' ),
					'vertical'    => __( 'Vertical', 'unique-elementor-widget-toolkit' ),
					'sides'       => __( 'Diagonal Left', 'unique-elementor-widget-toolkit' ),
					'sides-right' => __( 'Diagonal Right', 'unique-elementor-widget-toolkit' ),
				),
				'default'            => 'horizontal',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'display_label',
			array(
				'label'   => __( 'Display Label', 'unique-elementor-widget-toolkit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'on-hover' => __( 'On Hover', 'unique-elementor-widget-toolkit' ),
					'always'   => __( 'Always', 'unique-elementor-widget-toolkit' ),
				),
				'default' => 'always',
			)
		);

		$this->add_control(
			'display_handle',
			array(
				'label'   => __( 'Display Handle', 'unique-elementor-widget-toolkit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'on-hover' => __( 'On Hover', 'unique-elementor-widget-toolkit' ),
					'always'   => __( 'Always', 'unique-elementor-widget-toolkit' ),
				),
				'default' => 'always',
			)
		);

		$this->add_control(
			'mouse_move',
			array(
				'label'              => __( 'Move On Hover', 'unique-elementor-widget-toolkit' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Show', 'unique-elementor-widget-toolkit' ),
				'label_off'          => __( 'Hide', 'unique-elementor-widget-toolkit' ),
				'return_value'       => 'yes',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'wiggle',
			array(
				'label'              => __( 'Wiggle', 'unique-elementor-widget-toolkit' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Show', 'unique-elementor-widget-toolkit' ),
				'label_off'          => __( 'Hide', 'unique-elementor-widget-toolkit' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'wiggle_timeout',
			array(
				'label'              => __( 'Wiggle Delay', 'unique-elementor-widget-toolkit' ),
				'type'               => Controls_Manager::SLIDER,
				'default'            => array(
					'size' => 1.5,
				),
				'size_units'         => array( 'px' ),
				'range'              => array(
					'px' => array(
						'min'  => 0.1,
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'condition'          => array(
					'wiggle' => 'yes',
				),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'visible_ratio',
			array(
				'label'              => __( 'Visible Ratio', 'unique-elementor-widget-toolkit' ),
				'type'               => Controls_Manager::SLIDER,
				'separator'          => 'before',
				'default'            => array(
					'size' => 50,
				),
				'size_units'         => array( '%' ),
				'range'              => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					),
				),
				'frontend_available' => true,
			)
		);

		$this->end_controls_section();


    }


    protected function uewtk_before_after_styles(){

		$this->start_controls_section(
			'section_general_style',
			array(
				'label' => __( 'General', 'unique-elementor-widget-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'item_height',
			array(
				'label'       => __( 'Height', 'unique-elementor-widget-toolkit' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'vh', '%' ),
				'default'     => array(
					'unit' => 'vh',
				),
				'range'       => array(
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
				),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} .uewtk-compare-wrapper, {{WRAPPER}} .uewtk-compare-item img' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'overlay_color',
			array(
				'label'     => __( 'Overlay Color', 'unique-elementor-widget-toolkit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .uewtk-compare-container .uewtk-compare-overlay' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

    }

    public function get_style_depends(): array {
		return [ 'uewtk-button-after-css' ];
	}

    public function get_script_depends(): array {
        return [ 'uewtk-before-after-js' ];
    }


    /**
     * Register the widget controls.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls() {
       
        $this->uewtk_before_after_controls();

        $this->uewtk_before_after_styles();
        
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

	
        include UEWTK_WIDGETS . 'uewtk-before-after/layout/frontend.php';
    }
}