<?php
/**
 * Admin View: Notice - Updating
 */

if (!defined('ABSPATH')) {
    exit;
}

?>
<div id="message" class="updated nepali-calendar-message ur-connect">
    <p><strong><?php _e('Nepali Calendar Data Update', 'nepali-calendar'); ?></strong>
        &#8211; <?php _e('Your database is being updated in the background.', 'nepali-calendar'); ?> <a
                href="<?php echo esc_url(add_query_arg('force_update_nepali_calendar', 'true', admin_url('options-general.php?page=nepali-calendar'))); ?>"><?php _e('Taking a while? Click here to run it now.', 'nepali-calendar'); ?></a>
    </p>
</div>
