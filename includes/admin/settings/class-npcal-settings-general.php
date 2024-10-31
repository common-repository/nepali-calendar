<?php
/**
 * NepaliCalendar General Settings
 *
 * @author      ThemeEgg
 * @category    Admin
 * @package     NepaliCalendar/Admin
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'NPCAL_Settings_General', false ) ) :

	/**
	 * NPCAL_Admin_Settings_General.
	 */
	class NPCAL_Settings_General extends NPCAL_Settings_Page {

		/**
		 * Constructor.
		 */
		public function __construct() {

			$this->id    = 'general';
			$this->label = NPCAL_Lang::text( 'general_tab_label' );

			add_filter( 'nepali_calendar_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
			add_action( 'nepali_calendar_settings_' . $this->id, array( $this, 'output' ) );
			add_action( 'nepali_calendar_settings_save_' . $this->id, array( $this, 'save' ) );
		}

		/**
		 * Get settings array.
		 *
		 * @return array
		 */
		public function get_settings() {


			$settings = array(

				array(
					'title' => NPCAL_Lang::text( 'general_option' ),
					'type'  => 'title',
					'desc'  => '',
					'id'    => 'general_options'
				),

				array(
					'title'    => NPCAL_Lang::text( 'dialog_width' ),
					'desc'     => NPCAL_Lang::text( 'dialog_width_description' ),
					'id'       => 'nepali_calendar_width',
					'default'  => 'auto',
					'type'     => 'text',
					'desc_tip' => true,


				),
				array(
					'title'    => NPCAL_Lang::text( 'show_dialog_close_button' ),
					'desc'     => NPCAL_Lang::text( 'show_dialog_close_button_description' ),
					'id'       => 'nepali_calendar_show_close_button',
					'type'     => 'checkbox',
					'default'  => 'yes',
					'autoload' => false,
					'desc_tip' => true,


				),
				array(
					'title'    => NPCAL_Lang::text( 'close_button_label' ),
					'desc'     => NPCAL_Lang::text( 'close_button_label_description' ),
					'id'       => 'nepali_calendar_close_button_label',
					'default'  => __( 'Close', 'nepali-calendar' ),
					'type'     => 'text',
					'autoload' => false,

					'desc_tip' => true,


				),


				array( 'type' => 'sectionend', 'id' => 'general_options' ),

			);


			return apply_filters( 'nepali_calendar_get_settings_' . $this->id, $settings );

		}


		/**
		 * Save settings.
		 */
		public function save() {

			$settings = $this->get_settings();


			NPCAL_Admin_Settings::save_fields( $settings );
		}
	}

endif;

return new NPCAL_Settings_General();
