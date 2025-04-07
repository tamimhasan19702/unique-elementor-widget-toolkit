<?php
namespace UniqueElementorToolkit\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Widget_Base;
use WP_Query;
use UniqueElementorToolkit\Controls\Uewtk_Foreground;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Unique Post Grid
 *
 * Elementor widget for Unique Post Grid
 *
 * @since 1.0.0
 */
class Unique_Post_Grid extends Widget_Base {

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
        return 'unique-post-grid';
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
        return __( 'Unique Post Grid', 'unique-elementor-widget-toolkit' );
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

    protected function uewtk_post_grid_controls(){

        $post_types = \uewtk_elementor_get_post_types();
        $post_types['by_id'] = __( 'By ID', 'unique-elementor-widget-toolkit' );
        $post_types['source_dynamic'] = __( 'Dynamic', 'unique-elementor-widget-toolkit' );

        $taxonomies = \uewtk_elementor_get_taxonomies( array( 'show_in_nav_menus' => true ) );

        $this->start_controls_section(
            'section_general',
            [
                'label' => __( 'General', 'unique-elementor-widget-toolkit' ),
            ]
        );

        $this->add_control(
			'layout',
			array(
				'label'   => __( 'Layout', 'unique-elementor-widget-toolkit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => array(
					'1'  => __( 'Layout 1', 'unique-elementor-widget-toolkit' ),
					'2'  => __( 'Layout 2', 'unique-elementor-widget-toolkit' ),
					'3'  => __( 'Layout 3', 'unique-elementor-widget-toolkit' ),
					'4'  => __( 'Layout 4', 'unique-elementor-widget-toolkit' ),
					'5'  => __( 'Layout 5', 'unique-elementor-widget-toolkit' ),
					'6'  => __( 'Layout 6', 'unique-elementor-widget-toolkit' ),
					'7'  => __( 'Layout 7', 'unique-elementor-widget-toolkit' ),
					'8'  => __( 'Layout 8', 'unique-elementor-widget-toolkit' ),
					'9'  => __( 'Layout 9', 'unique-elementor-widget-toolkit' ),
					'10' => __( 'Layout 10', 'unique-elementor-widget-toolkit' ),
				),
			)
		);

        $this->add_responsive_control(
			'column_grid',
			array(
				'label'              => __( 'Columns', 'unique-elementor-widget-toolkit' ),
				'type'               => Controls_Manager::SELECT,
				'desktop_default'    => '3',
				'tablet_default'     => '2',
				'mobile_default'     => '1',
				'options'            => array(
					'1' => __( '1', 'unique-elementor-widget-toolkit' ),
					'2' => __( '2', 'unique-elementor-widget-toolkit' ),
					'3' => __( '3', 'unique-elementor-widget-toolkit' ),
					'4' => __( '4', 'unique-elementor-widget-toolkit' ),
					'5' => __( '5', 'unique-elementor-widget-toolkit' ),
					'6' => __( '6', 'unique-elementor-widget-toolkit' ),
				),
				'render_type'        => 'template',
				'frontend_available' => true,
			)
		);

       

        $this->end_controls_section();
    }


    protected function uewtk_post_grid_styles(){

        $this->start_controls_section(
			'section_style',
			array(
				'label' => __( 'General', 'unique-elementor-widget-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);


       

        $this->end_controls_section();
    }

    public function get_style_depends(): array {
		return [ 'uewtk-post-grid-css', 'uewtk-icons' ,'uewtk-editor-style'];
	}

    public function get_script_depends(): array {
        return [ 'uewtk-post-grid-js' ];
    }


    /**
     * Register the widget controls.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls() {
       
        $this->uewtk_post_grid_controls();

        $this->uewtk_post_grid_styles();
        
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
        include UEWTK_WIDGETS . 'uewtk-post-grid/layout/frontend.php';
    }
}