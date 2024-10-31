<?php
/**
 * Nepali_Calendar Admin.
 *
 * @class    NPCAL_Admin
 * @version  1.0.0
 * @package  Nepali_Calendar/Admin
 * @category Admin
 * @author   ThemeEgg
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * NPCAL_Admin Class
 */
class NPCAL_Admin
{

    /**
     * Hook in tabs.
     */
    public function __construct()
    {

        add_action('init', array($this, 'includes'));
    }

    /**
     * Includes any classes we need within admin.
     */
    public function includes()
    {

        include_once(dirname(__FILE__) . '/npcal-admin-functions.php');

        include_once(dirname(__FILE__) . '/class-npcal-admin-menus.php');

        include_once(dirname(__FILE__) . '/class-npcal-admin-assets.php');

        include_once(dirname(__FILE__) . '/class-npcal-admin-notices.php');

    }
}

return new NPCAL_Admin();
