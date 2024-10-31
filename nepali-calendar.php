<?php
/**
 * Plugin Name: Nepali Calendar
 * Plugin URI: http://themeegg.com/plugins/nepali-calendar
 * Description: Nepali calendar wordpress plugin
 * Version: 1.0.0
 * Author: ThemeEgg
 * Author URI: http://themeegg.com
 * Requires at least: 4.0
 * Tested up to: 4.8
 *
 * Text Domain: nepali-calendar
 * Domain Path: /languages/
 *
 * @package  Nepali_Calendar
 * @category Core
 * @author   ThemeEgg
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Nepali_Calendar' ) ) :

	/**
	 * Main Nepali_Calendar Class.
	 *
	 * @class   Nepali_Calendar
	 * @version 1.0.0
	 */
	final class Nepali_Calendar {

		/**
		 * Plugin version.
		 * @var string
		 */
		public $version = '1.0.0';

		/**
		 * Query instance.
		 *
		 *
		 */
		public $query = null;

		/**
		 * Instance of this class.
		 * @var object
		 */
		protected static $_instance = null;

		/**
		 * Return an instance of this class.
		 * @return object A single instance of this class.
		 */
		public static function instance() {
			// If the single instance hasn't been set, set it now.
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Cloning is forbidden.
		 * @since 1.0
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'nepali-calendar' ), '1.0' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 * @since 1.0
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'nepali-calendar' ), '1.0' );
		}

		/**
		 * FlashToolkit Constructor.
		 */
		public function __construct() {
			$this->define_constants();

			$this->includes();

			$this->init_hooks();

			do_action( 'nepali-calendar-loaded' );
		}

		/**
		 * Hook into actions and filters.
		 */
		private function init_hooks() {

			register_activation_hook( __FILE__, array( 'NPCAL_Install', 'install' ) );

			add_action( 'after_setup_theme', array( $this, 'include_template_functions' ), 11 );


			add_action( 'init', array( $this, 'init' ), 0 );

			add_action( 'init', array( 'NPCAL_Shortcodes', 'init' ) );


		}

		public function init() {
			// Before init action.
			do_action( 'before_nepali_calendar_init' );

			// Set up localisation.
			$this->load_plugin_textdomain();


			// Init action.
			do_action( 'after_nepali_calendar_init' );
		}

		/**
		 * Define FT Constants.
		 */
		private function define_constants() {
			$this->define( 'NPCAL_DS', DIRECTORY_SEPARATOR );
			$this->define( 'NPCAL_PLUGIN_FILE', __FILE__ );
			$this->define( 'NPCAL_ABSPATH', dirname( __FILE__ ) . NPCAL_DS );
			$this->define( 'NPCAL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			$this->define( 'NPCAL_VERSION', $this->version );
			$this->define( 'NPCAL_FORM_PATH', NPCAL_ABSPATH . 'includes' . NPCAL_DS . 'form' . NPCAL_DS );
		}


		/**
		 * Define constant if not already set.
		 *
		 * @param string $name
		 * @param string|bool $value
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * What type of request is this?
		 *
		 * @param  string $type admin or frontend.
		 *
		 * @return bool
		 */
		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin' :
					return is_admin();
				case 'frontend' :
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
			}
		}


		public function include_template_functions() {
			//include_once( UR_ABSPATH . 'includes/functions-ur-template.php' );
		}

		/**
		 * Includes.
		 */
		private function includes() {


			// core
			include( NPCAL_ABSPATH . 'includes' . NPCAL_DS . 'npcal-core-functions.php' );

			/**
			 * Class autoloader.
			 */
			include_once( NPCAL_ABSPATH . 'includes/class-npcal-autoloader.php' );


			/**
			 * Interfaces.
			 */

			include_once( NPCAL_ABSPATH . 'includes/interfaces/class-npcal-shortcode-interface.php' );

			/**
			 * Core classes.
			 */

			include_once( NPCAL_ABSPATH . 'includes/class-npcal-install.php' );

			include_once( NPCAL_ABSPATH . 'includes/class-npcal-ajax.php' );

			if ( $this->is_request( 'admin' ) ) {

				include_once( NPCAL_ABSPATH . 'includes/admin/class-npcal-admin.php' );
			}

			if ( $this->is_request( 'frontend' ) ) {


				$this->frontend_includes();
			}


			$this->query = new NPCAL_Query();

		}


		/**
		 * Include required frontend files.
		 */
		public function frontend_includes() {
			include_once( NPCAL_ABSPATH . 'includes/frontend/class-npcal-frontend.php' );

			include_once( NPCAL_ABSPATH . 'includes/class-npcal-shortcodes.php' );         // Shortcodes Class

		}

		/**
		 * Load Localisation files.
		 *
		 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
		 *
		 * Locales found in:
		 *      - WP_LANG_DIR/nepali-calendar/nepali-calendar-LOCALE.mo
		 *      - WP_LANG_DIR/plugins/nepali-calendar-LOCALE.mo
		 */
		public function load_plugin_textdomain() {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'nepali-calendar' );

			load_textdomain( 'nepali-calendar', WP_LANG_DIR . '/nepali-calendar/nepali-calendar-' . $locale . '.mo' );
			load_plugin_textdomain( 'nepali-calendar', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Get the template path.
		 * @return string
		 */
		public function template_path() {
			return apply_filters( 'nepali_calendar_template_path', 'nepali-calendar/' );
		}

		/**
		 * Get the plugin url.
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		/**
		 * Get the plugin path.
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Get Ajax URL.
		 * @return string
		 */
		public function ajax_url() {
			return admin_url( 'admin-ajax.php', 'relative' );
		}
	}

endif;

/**
 * Main instance of Nepali_Calendar.
 *
 * Returns the main instance of FT to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object
 */
function NPCAL() {
	return Nepali_Calendar::instance();
}

// Global for backwards compatibility.
$GLOBALS['nepali-calendar'] = NPCAL();
