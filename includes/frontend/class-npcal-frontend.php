<?php
/**
 * Nepali_Calendar Frontend.
 *
 * @class    NPCAL_Admin
 * @version  1.0.0
 * @package  Nepali_Calendar/Frontend
 * @category Admin
 * @author   ThemeEgg
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * NPCAL_Admin Class
 */
class NPCAL_Frontend
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

        include_once(NPCAL_ABSPATH . 'includes' . NPCAL_DS . 'frontend' . NPCAL_DS . 'class-npcal-frontend-scripts.php');

       
    }
}

return new NPCAL_Frontend();
