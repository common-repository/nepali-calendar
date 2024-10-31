<?php
/**
 * Admin View: Notice - Updated
 */

if (!defined('ABSPATH')) {
    exit;
}

?>
<div id="message" class="updated nepali-calendar-message ess-connect">
    <a class="nepali-calendar-message-close notice-dismiss"
       href="<?php echo esc_url(wp_nonce_url(add_query_arg('ur-hide-notice', 'update', remove_query_arg('do_update_nepali_calendar')), 'nepali_calendar_hide_notices_nonce', '_ur_notice_nonce')); ?>"><?php _e('Dismiss', 'nepali-calendar'); ?></a>

    <p><?php _e('Nepali Calendar data update complete. Thank you for updating to the latest version!', 'nepali-calendar'); ?></p>
</div>
