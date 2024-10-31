<?php
/**
 * Nepali Calendar Core Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @author      ThemeEgg
 * @category    Core
 * @package     Nepali_Calendar/Functions
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


include( 'npcal-formatting-functions.php' );
include( 'npcal-widget-functions.php' );


/**
 * Display a Nepali Calendar help tip.
 *
 * @since  1.0.0
 *
 * @param  string $tip Help tip text
 * @param  bool $allow_html Allow sanitized HTML if true or escape
 *
 * @return string
 */
function npcal_help_tip( $tip, $allow_html = false ) {
	if ( $allow_html ) {
		$tip = npcal_sanitize_tooltip( $tip );
	} else {
		$tip = esc_attr( $tip );
	}

	return '<span class="nepali-calendar-help-tip" data-tip="' . $tip . '"></span>';
}

/**
 * Get template part (for templates like the shop-loop).
 *
 * NPCAL_TEMPLATE_DEBUG_MODE will prevent overrides in themes from taking priority.
 *
 * @access public
 *
 * @param mixed $slug
 * @param string $name (default: '')
 */
function npcal_get_template_part( $slug, $name = '' ) {
	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/nepali-calendar/slug-name.php
	if ( $name && ! NPCAL_TEMPLATE_DEBUG_MODE ) {
		$template = locate_template( array( "{$slug}-{$name}.php", NPCAL()->template_path() . "{$slug}-{$name}.php" ) );
	}

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( NPCAL()->plugin_path() . "/templates/{$slug}-{$name}.php" ) ) {
		$template = NPCAL()->plugin_path() . "/templates/{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/teg-tfwitter-api/slug.php
	if ( ! $template && ! NPCAL_TEMPLATE_DEBUG_MODE ) {
		$template = locate_template( array( "{$slug}.php", NPCAL()->template_path() . "{$slug}.php" ) );
	}

	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'npcal_get_template_part', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @access public
 *
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 */
function npcal_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args );
	}

	$located = npcal_locate_template( $template_name, $template_path, $default_path );

	if ( ! file_exists( $located ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( __( '%s does not exist.', 'nepali-calendar' ), '<code>' . $located . '</code>' ), '1.0' );

		return;
	}

	// Allow 3rd party plugin filter template file from their plugin.
	$located = apply_filters( 'npcal_get_template', $located, $template_name, $args, $template_path, $default_path );

	do_action( 'nepali_calendar_before_template_part', $template_name, $template_path, $located, $args );


	include( $located );

	do_action( 'nepali_calendar_after_template_part', $template_name, $template_path, $located, $args );
}


/**
 * Like npcal_get_template, but returns the HTML instead of outputting.
 *
 * @see npcal_get_template
 * @since 2.5.0
 *
 * @param string $template_name
 * @param array $args
 * @param string $template_path
 * @param string $default_path
 *
 * @return string
 */
function npcal_get_template_html( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	ob_start();
	npcal_get_template( $template_name, $args, $template_path, $default_path );

	return ob_get_clean();
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *        yourtheme        /    $template_path    /    $template_name
 *        yourtheme        /    $template_name
 *        $default_path    /    $template_name
 *
 * @access public
 *
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 *
 * @return string
 */
function npcal_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	if ( ! $template_path ) {
		$template_path = NPCAL()->template_path();
	}

	if ( ! $default_path ) {
		$default_path = NPCAL()->plugin_path() . '/templates/';
	}

	// Look within passed path within the theme - this is priority.
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name,
		)
	);

	// Get default template/
	if ( ! $template || NPCAL_TEMPLATE_DEBUG_MODE ) {
		$template = $default_path . $template_name;
	}

	// Return what we found.
	return apply_filters( 'nepali_calendar_locate_template', $template, $template_name, $template_path );
}

function npcal_include( $path ) {
	$path = str_replace( '/', DIRECTORY_SEPARATOR, $path );
	$path = str_replace( '\\', DIRECTORY_SEPARATOR, $path );
	if ( ! file_exists( $path ) ) {

		die( 'File not exists: ' . $path );
	}
	include_once( $path );

}

function npcal_templates() {


	return apply_filters( 'nepali_calendar_templates', array(


		'default' => __( 'Default', 'nepali-calendar' ),
		'dark'    => __( 'Dark Theme', 'nepali-calendar' ),
		'light'   => __( 'Light Theme', 'nepali-calendar' ),


	) );
}


