<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * NPCAL_Shortcodes class
 *
 * @class       NPCAL_Shortcodes
 * @version     1.0.0
 * @package     Nepali_Calendar/Classes
 * @category    Class
 * @author      ThemeEgg
 */
class NPCAL_Shortcodes
{

    /**
     * Init shortcodes.
     */
    public static function init()
    {
        $shortcodes = array(

            'nepali_calendar' => __CLASS__ . '::nepali_calendar',

        );

        foreach ($shortcodes as $shortcode => $function) {
            add_shortcode(apply_filters("{$shortcode}_shortcode_tag", $shortcode), $function);
        }


    }

    /**
     * Shortcode Wrapper.
     *
     * @param string[] $function
     * @param array $atts (default: array())
     * @param array $wrapper
     *
     * @return string
     */
    public static function shortcode_wrapper(
        $function,
        $atts = array(),
        $wrapper = array(
            'class' => 'nepali-calendar-wrapper',
            'before' => null,
            'after' => null,
        )
    )
    {
        ob_start();

        echo empty($wrapper['before']) ? '<div class="' . esc_attr($wrapper['class']) . '">' : $wrapper['before'];
        call_user_func($function, $atts);
        echo empty($wrapper['after']) ? '</div>' : $wrapper['after'];

        return ob_get_clean();
    }

    /**
     * nepali calendar shortcodes
     *
     * @param mixed $atts
     * @return string
     */
    public static function nepali_calendar($atts)
    {
        return self::shortcode_wrapper(array('NPCAL_Shortcode_Nepali_Calendar', 'output'), $atts);
    }

}
