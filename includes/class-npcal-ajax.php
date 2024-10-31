<?php
/**
 * Nepali_Calendar NPCAL_Ajax
 *
 * AJAX Event Handler
 *
 * @class    NPCAL_Ajax
 * @version  1.0.0
 * @package  Nepali_Calendar/Classes
 * @category Class
 * @author   ThemeEgg
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * NPCAL_Ajax Class
 */
class NPCAL_Ajax
{

    /**
     * Hooks in ajax handlers
     */
    public static function init()
    {return;

        self::add_ajax_events();
    }

    /**
     * Hook in methods - uses WordPress ajax handlers (admin-ajax)
     */
    public static function add_ajax_events()
    {

        $ajax_events = array(

            'user_input_dropped' => true,

        );

        foreach ($ajax_events as $ajax_event => $nopriv) {

            add_action('wp_ajax_nepali_calendar_' . $ajax_event, array(__CLASS__, $ajax_event));

            if ($nopriv) {
                add_action('wp_ajax_nopriv_nepali_calendar_' . $ajax_event, array(__CLASS__, $ajax_event));
            }
        }
    }

    /**
     * user input dropped function
     */
    public static function user_input_dropped()
    {

        try {

            check_ajax_referer('user_input_dropped_nonce', 'security');

            $data = array();

            wp_send_json_success(array("data" => $data));

        } catch (Exception $e) {

            wp_send_json_success();

        }
    }


}

NPCAL_Ajax::init();