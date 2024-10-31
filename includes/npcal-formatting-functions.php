<?php
/**
 * NepaliCalendar Formatting
 *
 * Functions for formatting data.
 *
 * @author        ThemeEgg
 * @category    Core
 * @package    NepaliCalendar/Functions
 * @version     1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Sanitize a string destined to be a tooltip.
 *
 * @since 1.0.0 Tooltips are encoded with htmlspecialchars to prevent XSS. Should not be used in conjunction with esc_attr()
 * @param string $var
 * @return string
 */
function npcal_sanitize_tooltip($var)
{
    return htmlspecialchars(wp_kses(html_entity_decode($var), array(
        'br' => array(),
        'em' => array(),
        'strong' => array(),
        'small' => array(),
        'span' => array(),
        'ul' => array(),
        'li' => array(),
        'ol' => array(),
        'p' => array(),
    )));
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * @param string|array $var
 * @return string|array
 */
function npcal_clean($var)
{
    if (is_array($var)) {
        return array_map('npcal_clean', $var);
    } else {
        return is_scalar($var) ? sanitize_text_field($var) : $var;
    }
}