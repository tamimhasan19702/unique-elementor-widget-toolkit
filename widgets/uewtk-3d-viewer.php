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
        return [ 'model-viewer' ]; // Add the model-viewer script as a dependency
    }

    /**
     * Register the widget controls.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls() {
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

        $this->end_controls_section();

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
     * Render the widget output on the frontend.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render() {
        // Enqueue the model-viewer script
        wp_register_script(
            'model-viewer',
            'https://ajax.googleapis.com/ajax/libs/model-viewer/3.1.1/model-viewer.min.js',
            [],
            '3.1.1',
            true
        );
        wp_enqueue_script( 'model-viewer' );

        $settings = $this->get_settings_for_display();
        $model_src = esc_url( $settings['model_src'] ); // Get the model source URL

        ?>
<div class="unique-3d-viewer">
    <h2 class="title" style="text-transform: <?php echo esc_attr( $settings['text_transform'] ); ?>">
        <?php echo esc_html( $settings['title'] ); ?>
    </h2>
    <model-viewer alt="<?php echo esc_attr( $settings['title'] ); ?>" src="<?php echo $model_src; ?>" camera-controls
        auto-rotate disable-zoom>
    </model-viewer>
</div>
<?php 
    }
}