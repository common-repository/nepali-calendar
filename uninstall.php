<?php
/**
 * Nepali_Calendar Uninstall
 *
 * Uninstalls the plugin and associated data.
 *
 * @author   ThemeEgg
 * @category Core
 * @package  Nepali_Calendar/Uninstaller
 * @version  1.0.0
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/*
 * Only remove ALL product and page data if NPCAL_REMOVE_ALL_DATA constant is set to true in user's
 * wp-config.php. This is to prevent data loss when deleting the plugin from the backend
 * and to ensure only the site owner can perform this action.
 */
if ( defined( 'NPCAL_REMOVE_ALL_DATA' ) && true === NPCAL_REMOVE_ALL_DATA ) {

}
