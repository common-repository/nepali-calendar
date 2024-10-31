<?php
/**
 * nepali calendar widget function
 *
 * Widget related functions and widget registration.
 *
 * @author        ThemeEgg
 * @category    Core
 * @package    NepaliCalendar/Functions
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include widget classes.
include_once( dirname( __FILE__ ) . '/abstracts/abstract-npcal-widget.php' );
include_once( dirname( __FILE__ ) . '/widgets/class-npcal-widget-nepali-calendar.php' );


/**
 * Register Widgets.
 *
 * @since 1.0.0
 */
function npcal_register_widgets() {

	register_widget( 'NPCAL_Widget_Nepali_Calendar' );

}

add_action( 'widgets_init', 'npcal_register_widgets' );
