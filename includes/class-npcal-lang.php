<?php
/**
 * Contains language string
 *
 * @class       NPCAL_Lang
 * @version     1.0.0
 * @package     Nepali_Calendar/Classes
 * @category    Class
 * @author      ThemeEgg
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * NPCAL_Lang Class.
 */
class NPCAL_Lang {


	public static function text( $language_key ) {


		$language_array = self::language_array();

		if ( isset( $language_array[ $language_key ] ) ) {


			return $language_array[ $language_key ];

		}

		return $language_key;

	}


	private static function language_array() {


		$language_array = array(

			'close_button_label' => __( 'Close button label', 'nepali-calendar' ),

			'general_tab_label' => __( 'General', 'nepali-calendar' ),

			'general_option' => __( 'General options', 'nepali-calendar' ),

			'dialog_width' => __( 'Dialog width', 'nepali-calendar' ),

			'dialog_width_description' => __( 'Dialog width, you can use, % or px or auto', 'nepali-calendar' ),

			'show_dialog_close_button' => __( 'Show dialog close button ? ', 'nepali-calendar' ),

			'show_dialog_close_button_description' => __( 'Label for dialog close button.', 'nepali-calendar' ),

			'nifty_modal_label' => __( 'Nifty Modal Setting', 'nepali-calendar' ),

		);


		return apply_filters( 'nepali_calendar_language_array', $language_array );
	}

}
