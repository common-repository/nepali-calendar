<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * NPCAL Shortcodes
 *
 * Used to nepali calendar
 *
 * @author       ThemeEgg
 * @category    Shortcodes
 * @package     Nepali_Calendar/Shortcodes
 * @version     1.0.0
 */
class NPCAL_Shortcode_Nepali_Calendar implements NPCAL_Shortcode_Interface {


	/**
	 * Output the cart shortcode.
	 *
	 * @param array $atts
	 */
	public static function output( $atts = array() ) {
//		if ( empty( $atts ) ) {
//			return '';
//		}

		npcal_get_template( 'shortcodes/content-shortcode-nepali-calendar.php' );


	}
}
