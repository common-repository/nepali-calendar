<?php
/**
 * Installation related functions and actions.
 *
 * @class    NPCAL_Install
 * @version  1.0.0
 * @package  Nepali_Calendar/Classes
 * @category Admin
 * @author   ThemeEgg
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * NPCAL_Install Class.
 */
class NPCAL_Install {
	/** @var array DB updates and callbacks that need to be run per version */
	private static $db_updates = array(
		'1.0.0' => array(
			'ur_update_100_db_version',
		),
	);

	/** @var object Background update class */
	private static $background_updater;

	/**
	 * Hook in tabs.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'check_version' ), 5 );
		add_action( 'init', array( __CLASS__, 'init_background_updater' ), 5 );
		add_action( 'admin_init', array( __CLASS__, 'install_actions' ) );

		add_filter( 'plugin_action_links_' . NPCAL_PLUGIN_BASENAME, array( __CLASS__, 'plugin_action_links' ) );
		add_filter( 'plugin_row_meta', array( __CLASS__, 'plugin_row_meta' ), 10, 2 );
	}

	/**
	 * Init background updates.
	 */
	public static function init_background_updater() {
		include_once( 'class-npcal-background-updater.php' );
		self::$background_updater = new NPCAL_Background_Updater();
	}

	/**
	 * Check Nepali_Calendar version and run the updater is required.
	 *
	 * This check is done on all requests and runs if the versions do not match.
	 */
	public static function check_version() {
		if ( ! defined( 'IFRAME_REQUEST' ) && get_option( 'nepali_calendar_version' ) !== NPCAL()->version ) {
			self::install();
			do_action( 'nepali_calendar_updated' );
		}
	}

	/**
	 * Install actions when a update button is clicked within the admin area.
	 *
	 * This function is hooked into admin_init to affect admin only.
	 */
	public static function install_actions() {
		if ( ! empty( $_GET['do_update_nepali_calendar'] ) ) {
			self::update();
			NPCAL_Admin_Notices::add_notice( 'update' );
		}
		if ( ! empty( $_GET['force_update_nepali_calendar'] ) ) {
			do_action( 'wp_ur_updater_cron' );
			wp_safe_redirect( admin_url( 'options-general.php?page=nepali-calendar' ) );
		}
	}

	/**
	 * Install NPCAL.
	 */
	public static function install() {
		global $wpdb;

		if ( ! is_blog_installed() ) {
			return;
		}

		if ( ! defined( 'NPCAL_INSTALLING' ) ) {
			define( 'NPCAL_INSTALLING', true );
		}

		// Ensure needed classes are loaded
		include_once( dirname( __FILE__ ) . '/admin/class-npcal-admin-notices.php' );


		// Queue upgrades wizard
		$current_ur_version = get_option( 'nepali_calendar_version', null );
		$current_db_version = get_option( 'nepali_calendar_db_version', null );

		NPCAL_Admin_Notices::remove_all_notices();

		// No versions? This is a new install :)
		if ( is_null( $current_ur_version ) && is_null( $current_db_version ) && apply_filters( 'nepali_calendar_enable_setup_wizard', true ) ) {
			set_transient( '_ur_activation_redirect', 1, 30 );
		}

		if ( ! is_null( $current_db_version ) && version_compare( $current_db_version, max( array_keys( self::$db_updates ) ), '<' ) ) {
			NPCAL_Admin_Notices::add_notice( 'update' );
		} else {
			self::update_db_version();
		}

		self::update_ur_version();

		// Flush rules after install
		do_action( 'nepali_calendar_flush_rewrite_rules' );

		/*
		 * Deletes all expired transients. The multi-table delete syntax is used
		 * to delete the transient record from table a, and the corresponding
		 * transient_timeout record from table b.
		 *
		 * Based on code inside core's upgrade_network() function.
		 */
		$sql = "DELETE a, b FROM $wpdb->options a, $wpdb->options b
			WHERE a.option_name LIKE %s
			AND a.option_name NOT LIKE %s
			AND b.option_name = CONCAT( '_transient_timeout_', SUBSTRING( a.option_name, 12 ) )
			AND b.option_value < %d";
		$wpdb->query( $wpdb->prepare( $sql, $wpdb->esc_like( '_transient_' ) . '%', $wpdb->esc_like( '_transient_timeout_' ) . '%', time() ) );

		// Trigger action
		do_action( 'nepali_calendar_installed' );
	}

	/**
	 * Update NPCAL version to current.
	 */
	private static function update_ur_version() {
		delete_option( 'nepali_calendar_version' );
		add_option( 'nepali_calendar_version', NPCAL()->version );
	}

	/**
	 * Push all needed DB updates to the queue for processing.
	 */
	private static function update() {
		$current_db_version = get_option( 'nepali_calendar_db_version' );
		$update_queued      = false;

		foreach ( self::$db_updates as $version => $update_callbacks ) {
			if ( version_compare( $current_db_version, $version, '<' ) ) {
				foreach ( $update_callbacks as $update_callback ) {
					self::$background_updater->push_to_queue( $update_callback );
					$update_queued = true;
				}
			}
		}

		if ( $update_queued ) {
			self::$background_updater->save()->dispatch();
		}
	}

	/**
	 * Update DB version to current.
	 *
	 * @param string $version
	 */
	public static function update_db_version( $version = null ) {
		delete_option( 'nepali_calendar_db_version' );
		add_option( 'nepali_calendar_db_version', is_null( $version ) ? NPCAL()->version : $version );
	}


	/**
	 * Parse update notice from readme file
	 *
	 * @param  string $content
	 * @param  string $new_version
	 *
	 * @return string
	 */
	private static function parse_update_notice( $content, $new_version ) {
		// Output Upgrade Notice.
		$matches        = null;
		$regexp         = '~==\s*Upgrade Notice\s*==\s*=\s*(.*)\s*=(.*)(=\s*' . preg_quote( NPCAL_VERSION ) . '\s*=|$)~Uis';
		$upgrade_notice = '';

		if ( preg_match( $regexp, $content, $matches ) ) {
			$version = trim( $matches[1] );
			$notices = (array) preg_split( '~[\r\n]+~', trim( $matches[2] ) );

			// Check the latest stable version and ignore trunk.
			if ( $version === $new_version && version_compare( NPCAL_VERSION, $version, '<' ) ) {

				$upgrade_notice .= '<div class="ur_plugin_upgrade_notice">';

				foreach ( $notices as $index => $line ) {
					$upgrade_notice .= wp_kses_post( preg_replace( '~\[([^\]]*)\]\(([^\)]*)\)~', '<a href="${2}">${1}</a>', $line ) );
				}

				$upgrade_notice .= '</div> ';
			}
		}

		return wp_kses_post( $upgrade_notice );
	}

	/**
	 * Display action links in the Plugins list table.
	 *
	 * @param  array $actions
	 *
	 * @return array
	 */
	public static function plugin_action_links( $actions ) {
		$new_actions = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=nepali-calendar' ) . '" title="' . esc_attr( __( 'View Nepali Calendar Settings', 'nepali-calendar' ) ) . '">' . __( 'Settings', 'nepali-calendar' ) . '</a>',
		);


		return array_merge( $new_actions, $actions );
	}

	/**
	 * Display row meta in the Plugins list table.
	 *
	 * @param  array $plugin_meta
	 * @param  string $plugin_file
	 *
	 * @return array
	 */
	public static function plugin_row_meta( $plugin_meta, $plugin_file ) {
		if ( $plugin_file == NPCAL_PLUGIN_BASENAME ) {
			$new_plugin_meta = array(
				'docs'    => '<a href="' . esc_url( apply_filters( 'nepali_calendar_docs_url', 'http://docs.themeegg.com/docs/nepali-calendar/' ) ) . '" title="' . esc_attr( __( 'View Nepali Calendar Documentation', 'nepali-calendar' ) ) . '">' . __( 'Docs', 'nepali-calendar' ) . '</a>',
				'support' => '<a href="' . esc_url( apply_filters( 'nepali_calendar_support_url', 'http://support.themeegg.com/' ) ) . '" title="' . esc_attr( __( 'Visit Free Customer Support Forum', 'nepali-calendar' ) ) . '">' . __( 'Free Support', 'nepali-calendar' ) . '</a>',
			);

			return array_merge( $plugin_meta, $new_plugin_meta );
		}

		return (array) $plugin_meta;
	}
}

NPCAL_Install::init();
