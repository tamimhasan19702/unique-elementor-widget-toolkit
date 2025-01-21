<?php
namespace UniqueElementorToolkit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Unique 3D Viewer
 *
 * Elementor widget for Unique 3D Viewer
 *
 * @since 1.0.0
 */
class Unique_3D_Viewer extends Widget_Base {

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
        return 'unique-3d-viewer';
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
        return __( 'Unique 3D Viewer', 'unique-elementor-widget-toolkit' );
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
        return 'eicon-parallax';
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
    public function get_script_depends() {
        return [ 'model-viewer-loader', 'model-viewer-modern', 'model-viewer-legacy' ]; // Add the model-viewer script as a dependency
    }
 

    protected function uewtk_3d_viewer_controls(){
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'unique-elementor-widget-toolkit' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'unique-elementor-widget-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( '3D Model Viewer', 'unique-elementor-widget-toolkit' ),
            ]
        );

        $this->add_control(
            'model_src',
            [
                'label' => __( 'Model Source URL', 'unique-elementor-widget-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'https://assets.codepen.io/89905/nike_air_max_90.glb',
            ]
        );

        $this->add_control(
            'custom_html',
            [
                'label' => __( 'Custom HTML', 'unique-elementor-widget-toolkit' ),
                'type' => Controls_Manager::CODE,
                'default' => __( '<div>Your custom HTML here</div>', 'unique-elementor-widget-toolkit' ),
                'language' => 'html',
            ]
        );

        $this->end_controls_section();
    }


    protected function uewtk_3d_viewer_styles(){
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


    /**
     * Register the widget controls.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls() {
       
        $this->uewtk_3d_viewer_controls();

        $this->uewtk_3d_viewer_styles();
        
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
<div class="unique-3d-viewer">
    <h1>header</h1>
    <?php echo $settings['custom_html']; ?>
    <h1>footer</h1>
</div>
<?php 
    }
}