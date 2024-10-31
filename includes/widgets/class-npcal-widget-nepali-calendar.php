<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Twitter Trends Widget.
 *
 * Displays twitter trends widget.
 *
 * @author   ThemeEgg
 * @category Widgets
 * @package  NepaliCalendar/Widgets
 * @version  1.0
 * @extends  NPCAL_Widget
 */
class NPCAL_Widget_Nepali_Calendar extends NPCAL_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass    = 'nepali_calendar_widget';
		$this->widget_description = __( "Nepali Bikram Sambad Calendar.", 'nepali-calendar' );
		$this->widget_id          = 'nepali_calendar_widget';
		$this->widget_name        = __( 'Nepali Calendar', 'nepali-calendar' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Nepali Calendar', 'nepali-calendar' ),
				'label' => __( 'Title', 'nepali-calendar' ),
			),
		);

		parent::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		if ( apply_filters( 'nepali_calendar_widget_is_hidden', false ) ) {
			return;
		}

		$this->widget_start( $args, $instance );


		$twitter_feed_array = array();


		$data = array(

			'twitter_feeds_array' => $twitter_feed_array,

			'twitter_username' => get_option( 'nepali_calendar_twitter_username' ),

			'instance' => $instance
		);

		npcal_get_template( 'widgets/content-widget-nepali-calendar.php', $data );


		$this->widget_end( $args );
	}
}
