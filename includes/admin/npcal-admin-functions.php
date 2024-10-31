<?php
/**
 * Nepali_Calendar Admin Functions
 *
 * @author   ThemeEgg
 * @category Core
 * @package  Nepali_Calendar/Admin/Functions
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get all Nepali_Calendar screen ids.
 *
 * @return array
 */
function npcal_get_screen_ids() {

	$npcal_screen_id = sanitize_title( __( 'Nepali Calendar', 'nepali-calendar' ) );
	$screen_ids    = array(
		'toplevel_page_' . $npcal_screen_id,
		//$npcal_screen_id . '_page_teg_ta-reports',
	);


	return apply_filters( 'nepali_calendar_screen_ids', $screen_ids );
}


/**
 * Get current tab ID
 *
 * @return array
 */
function npcal_get_current_tab() {

	$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';

	return apply_filters( 'nepali_calendar_current_tab', $current_tab );
}

/**
 * Get current section
 *
 * @return array
 */
function npcal_get_current_section() {

	$current_tab = isset( $_GET['section'] ) ? $_GET['section'] : '';

	return apply_filters( 'nepali_calendar_current_section', $current_tab );
}




