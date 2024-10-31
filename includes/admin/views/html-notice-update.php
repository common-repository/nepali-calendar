<?php
/**
 * Admin View: Notice - Update
 */

if (!defined('ABSPATH')) {
    exit;
}

?>
<div id="message" class="updated nepali-calendar-message ur-connect">
    <p><strong><?php _e('Nepali Calendar Data Update', 'nepali-calendar'); ?></strong>
        &#8211; <?php _e('We need to update your site\'s database to the latest version.', 'nepali-calendar'); ?></p>
    <p class="submit"><a
                href="<?php echo esc_url(add_query_arg('do_update_nepali_calendar', 'true', admin_url('options-general.php?page=nepali-calendar'))); ?>"
                class="ur-update-now button-primary"><?php _e('Run the updater', 'nepali-calendar'); ?></a></p>
</div>
<script type="text/javascript">
    jQuery('.ur-update-now').click('click', function () {
        return window.confirm('<?php echo esc_js(__('It is strongly recommended that you backup your database before proceeding. Are you sure you wish to run the updater now?', 'nepali-calendar')); ?>'); // jshint ignore:line
    });
</script>
