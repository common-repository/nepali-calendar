<?php
/**
 * NepaliCalendar fronted scripts
 *
 * @class    NPCAL_Frontend_Scripts
 * @version  1.0.0
 * @package  NepaliCalendar/Admin
 * @category Admin
 * @author   ThemeEgg
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * NPCAL_Frontend_Scripts Class
 */
class NPCAL_Frontend_Scripts {

	/**
	 * Contains an array of script handles registered by UR.
	 *
	 * @var array
	 */
	private static $scripts = array();

	/**
	 * Contains an array of script handles registered by UR.
	 *
	 * @var array
	 */
	private static $styles = array();

	/**
	 * Contains an array of script handles localized by UR.
	 *
	 * @var array
	 */
	private static $wp_localize_scripts = array();

	/**
	 * Hook in methods.
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_scripts' ) );
		add_action( 'wp_print_scripts', array( __CLASS__, 'localize_printed_scripts' ), 5 );
		add_action( 'wp_print_footer_scripts', array( __CLASS__, 'localize_printed_scripts' ), 5 );
	}

	/**
	 * Get styles for the frontend.
	 *
	 * @return array
	 */
	public static function get_styles() {
		return apply_filters( 'nepali_calendar_enqueue_styles', array(
			'nepali-calendar-frontend-style' => array(
				'src'     => self::get_asset_url( 'assets/css/nepali-calendar-frontend.css' ),
				'deps'    => array( 'nepali-calendar-style' ),
				'version' => NPCAL_VERSION,
				'media'   => '',
				'has_rtl' => true,
			),
			'nepali-calendar-style'          => array(
				'src'     => self::get_asset_url( 'assets/css/nepali-calendar.css' ),
				'deps'    => array(),
				'version' => NPCAL_VERSION,
				'media'   => '',
				'has_rtl' => false,
			),
		) );
	}

	/**
	 * Return asset URL.
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	private static function get_asset_url( $path ) {
		return apply_filters( 'nepali_calendar_assets_url', plugins_url( $path, NPCAL_PLUGIN_FILE ), $path );
	}

	/**
	 * Register a script for use.
	 *
	 * @uses   wp_register_script()
	 * @access private
	 *
	 * @param  string $handle
	 * @param  string $path
	 * @param  string[] $deps
	 * @param  string $version
	 * @param  boolean $in_footer
	 */
	private static function register_script( $handle, $path, $deps = array( 'jquery' ), $version = NPCAL_VERSION, $in_footer = true ) {
		self::$scripts[] = $handle;
		wp_register_script( $handle, $path, $deps, $version, $in_footer );
	}

	/**
	 * Register and enqueue a script for use.
	 *
	 * @uses   wp_enqueue_script()
	 * @access private
	 *
	 * @param  string $handle
	 * @param  string $path
	 * @param  string[] $deps
	 * @param  string $version
	 * @param  boolean $in_footer
	 */
	private static function enqueue_script( $handle, $path = '', $deps = array( 'jquery' ), $version = NPCAL_VERSION, $in_footer = true ) {
		if ( ! in_array( $handle, self::$scripts ) && $path ) {
			self::register_script( $handle, $path, $deps, $version, $in_footer );
		}
		wp_enqueue_script( $handle );
	}

	/**
	 * Register a style for use.
	 *
	 * @uses   wp_register_style()
	 * @access private
	 *
	 * @param  string $handle
	 * @param  string $path
	 * @param  string[] $deps
	 * @param  string $version
	 * @param  string $media
	 * @param  boolean $has_rtl
	 */
	private static function register_style( $handle, $path, $deps = array(), $version = NPCAL_VERSION, $media = 'all', $has_rtl = false ) {
		self::$styles[] = $handle;
		wp_register_style( $handle, $path, $deps, $version, $media );

		if ( $has_rtl ) {
			wp_style_add_data( $handle, 'rtl', 'replace' );
		}
	}

	/**
	 * Register and enqueue a styles for use.
	 *
	 * @uses   wp_enqueue_style()
	 * @access private
	 *
	 * @param  string $handle
	 * @param  string $path
	 * @param  string[] $deps
	 * @param  string $version
	 * @param  string $media
	 * @param  boolean $has_rtl
	 */
	private static function enqueue_style( $handle, $path = '', $deps = array(), $version = NPCAL_VERSION, $media = 'all', $has_rtl = false ) {
		if ( ! in_array( $handle, self::$styles ) && $path ) {
			self::register_style( $handle, $path, $deps, $version, $media, $has_rtl );
		}
		wp_enqueue_style( $handle );
	}

	/**
	 * Register all UR scripts.
	 */
	private static function register_scripts() {
		$suffix           = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$register_scripts =
			array(
				'nepali-calendar-frontend-script' => array(
					'src'     => self::get_asset_url( 'assets/js/frontend/nepali-calendar-frontend' . $suffix . '.js' ),
					'deps'    => array( 'jquery', 'nepali-calendar-script' ),
					'version' => NPCAL_VERSION,
				),
				'nepali-calendar-script'          => array(
					'src'     => self::get_asset_url( 'assets/js/frontend/nepali-calendar' . $suffix . '.js' ),
					'deps'    => array( 'jquery' ),
					'version' => NPCAL_VERSION,
				),


			);
		foreach ( $register_scripts as $name => $props ) {
			self::register_script( $name, $props['src'], $props['deps'], $props['version'] );
		}
	}

	/**
	 * Register all UR styles.
	 */
	private static function register_styles() {
		$register_styles = array(
			'nepali-calendar-frontend-style' => array(
				'src'     => self::get_asset_url( 'assets/css/nepali-calendar-frontend.css' ),
				'deps'    => array( 'nepali-calendar-style' ),
				'version' => NPCAL_VERSION,
				'has_rtl' => true,
			),
			'nepali-calendar-style'          => array(
				'src'     => self::get_asset_url( 'assets/css/nepali-calendar.css' ),
				'deps'    => array(),
				'version' => NPCAL_VERSION,
				'has_rtl' => false,
			),
		);
		foreach ( $register_styles as $name => $props ) {
			self::register_style( $name, $props['src'], $props['deps'], $props['version'], 'all', $props['has_rtl'] );
		}
	}

	/**
	 * Register/queue frontend scripts.
	 */
	public static function load_scripts() {
		global $post;

		if ( ! did_action( 'before_nepali_calendar_init' ) ) {

			return;
		}

		self::register_scripts();
		self::register_styles();

		$has_shortcode = true;

		if ( $has_shortcode ) {

			self::enqueue_script( 'nepali-calendar-frontend-script' );
		}
		// CSS Styles
		if ( $enqueue_styles = self::get_styles() ) {
			foreach ( $enqueue_styles as $handle => $args ) {
				if ( ! isset( $args['has_rtl'] ) ) {
					$args['has_rtl'] = false;
				}
				//if ( $has_shortcode && npcal_is_modal_template( $handle ) ) {
					self::enqueue_style( $handle, $args['src'], $args['deps'], $args['version'], $args['media'], $args['has_rtl'] );
				//}
			}
		}
	}

	/**
	 * Localize a UR script once.
	 *
	 * @access private
	 *
	 * @param  string $handle
	 */
	private static function localize_script( $handle ) {
		if ( ! in_array( $handle, self::$wp_localize_scripts ) && wp_script_is( $handle ) && ( $data = self::get_script_data( $handle ) ) ) {
			$name                        = str_replace( '-', '_', $handle ) . '_params';
			self::$wp_localize_scripts[] = $handle;
			wp_localize_script( $handle, $name, apply_filters( $name, $data ) );
		}
	}

	/**
	 * Return data for script handles.
	 *
	 * @access private
	 *
	 * @param  string $handle
	 *
	 * @return array|bool
	 */
	private static function get_script_data( $handle ) {
		global $wp;

		switch ( $handle ) {
			case 'nepali-calendar-frontend-script' :
				return array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
				);
				break;

		}

		return false;
	}

	/**
	 * Localize scripts only when enqueued.
	 */
	public static function localize_printed_scripts() {
		foreach ( self::$scripts as $handle ) {
			self::localize_script( $handle );
		}
	}
}

NPCAL_Frontend_Scripts::init();