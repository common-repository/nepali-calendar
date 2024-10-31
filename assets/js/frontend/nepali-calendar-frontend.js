/*
 * global nepali_calendar_frontend_script_params
 */
(function ($, document, window) {

    var options = {};

    if ($('.nepali-calendar').length != 0) {
        $('.nepali-calendar').remodal(options).open();

        var dialog_width = nepali_calendar_frontend_script_params.dialog_width;

        if ('' != dialog_width && dialog_width != 'auto') {

            $('.nepali-calendar.remodal').css({

                width: dialog_width,
                'max-width': dialog_width
            });

        }
    }

    if ($('.npcal-nifty-modal .md-trigger').length != 0) {
 
        $('.npcal-nifty-modal .md-trigger').trigger('click');
    }
}(jQuery, document, window));
