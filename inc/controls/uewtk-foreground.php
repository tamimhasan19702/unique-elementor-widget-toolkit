<?php 


namespace UniqueElementorToolkit\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed 

class Uewtk_Foreground extends Group_Control_Base{



    /**
	 * Fields.
	 *
	 * Holds all the background control fields.
	 *
	 * @access protected
	 * @static
	 *
	 * @var array Background control fields.
	 */
	protected static $fields;

	/**
	 * Get background control type.
	 *
	 * Retrieve the control type, in this case.
	 *
	 * @return string Control type.
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 */
	public static function get_type() {
		return 'foreground';
	}

	/**
	 * Init fields.
	 *
	 * Initialize background control fields.
	 *
	 * @return array Control fields.
	 * @since 1.0.0
	 * @access public
	 *
	 */




}