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


if (!defined('ABSPATH'))
	exit; // Exit if accessed directly

/**
 * Unique Before After
 *
 * Elementor widget for Unique Before After
 *
 * @since 1.0.0
 */
class Unique_Before_After extends Widget_Base
{

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
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
	public function get_title()
	{
		return __('Unique Before After', 'unique-elementor-widget-toolkit');
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
	public function get_icon()
	{
		return 'eicon-before-after uewtk-label';
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
	public function get_categories()
	{
		return ['unique-elementor-widget-toolkit'];
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
	public function get_keywords()
	{
		return array('before', 'after', 'compare', 'comparison');
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

	protected function uewtk_before_after_controls()
	{
		$this->start_controls_section(
			'section_general',
			[
				'label' => __('General', 'unique-elementor-widget-toolkit'),
			]
		);



		$this->end_controls_section();
	}


	protected function uewtk_before_after_styles()
	{

		$this->start_controls_section(
			'section_style',
			array(
				'label' => __('General', 'unique-elementor-widget-toolkit'),
				'tab' => Controls_Manager::TAB_STYLE,
			)
		);



		$this->end_controls_section();
	}

	public function get_style_depends(): array
	{
		return ['uewtk-before-after-css', 'uewtk-icons', 'uewtk-editor-style'];
	}

	public function get_script_depends(): array
	{
		return ['uewtk-button-js'];
	}


	/**
	 * Register the widget controls.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls()
	{

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
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		include UEWTK_WIDGETS . 'uewtk-before-after/layout/frontend.php';
	}
}