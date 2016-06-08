jQuery(function () {
    var usuario = jQuery('#usuario').val();
    jQuery('#calendar').fullCalendar({
        header: {
            left: 'promptResource today prev,next,myCustomButton',
            center: 'title',
            right: 'agendaDay,timelineThreeDays,agendaWeek,month'
        },
        customButtons: {
//            myCustomButton: {
//                text: 'custom!',
//                click: function () {
//                    alert('clicked the custom button!');
//                }
//            }
        },
        fixedWeekCount: false,
        theme: true,
        weekNumbers: true,
        handleWindowResize: true,
        events: function() {
           aciona_ajax('{"usuario" : "'+usuario+'"}', 'rn_lista_compromisso');
           
//           alert(tes);
    }
            
            
        

    })
});
//jQuery(window).on('load', function () {
//    jQuery('#calendar').fullCalendar('render');
//});
//
//
//$('#calendar').fullCalendar({
//    events: function(start, end, timezone, callback) {
//        $.ajax({
//            url: 'myxmlfeed.php',
//            dataType: 'xml',
//            data: {
//                // our hypothetical feed requires UNIX timestamps
//                start: start.unix(),
//                end: end.unix()
//            },
//            success: function(doc) {
//                var events = [];
//                $(doc).find('event').each(function() {
//                    events.push({
//                        title: $(this).attr('title'),
//                        start: $(this).attr('start') // will be parsed
//                    });
//                });
//                callback(events);
//            }
//        });
//    }
//});