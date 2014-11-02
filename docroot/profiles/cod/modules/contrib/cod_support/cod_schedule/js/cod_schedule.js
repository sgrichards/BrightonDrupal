/**
 * Attaches the drag and drop behavior to scheduler
 */
(function ($) {
    Drupal.behaviors.cod_schedule = {
        attach: function (context) {
            $( ".sortable-sessions" ).sortable({
                connectWith: ".sortable-sessions",
                receive: function( event, ui ) {

                    var timeslot = event.target;
                    var session = ui.item;
                    var timeslot_id = $(timeslot).data('timeslot');
                    var session_nid = $(session).data('nid');
                    var timeroom_id = $(timeslot).attr('id');

                    $(session).append('<span class="throbber">Updating...</span>');
                    $.post( "/ajax/cod-schedule/update-session", { session:session_nid, timeslot:timeslot_id, timeroom:timeroom_id }, function( data ) {
                        $(session).children('.throbber').remove();
                    }, "json");

                }
            }).disableSelection();
        }
    };
})(jQuery);