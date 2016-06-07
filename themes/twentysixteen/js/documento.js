$(function () {
    $('#calendar').fullCalendar({
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
//        events: [
//            {
//                title: 'Cliente Corte de Cabelo  Com Fulano',
//                start: '2016-05-03T13:00:00',
//                constraint: 'businessHours'
//            },
//            {
//                title: 'Meeting',
//                start: '2016-05-13T11:00:00',
//                constraint: 'availableForMeeting', // defined below
//                color: '#000000'
//            },
//            {
//                title: 'Conference',
//                start: '2016-05-18',
//                end: '2016-05-20'
//            },
//            {
//                title: 'Party',
//                start: '2016-05-29T20:00:00'
//            },
//            // areas where "Meeting" must be dropped
//            {
//                id: 'availableForMeeting',
//                start: '2016-05-11T10:00:00',
//                end: '2016-05-11T16:00:00',
//                rendering: 'background'
//            },
//            {
//                id: 'availableForMeeting',
//                start: '2016-05-13T10:00:00',
//                end: '2016-05-13T16:00:00',
//                rendering: 'background'
//            },
//            // red areas where no events can be dropped
//            {
//                start: '2016-05-24',
//                end: '2016-05-28',
//                overlap: false,
//                color: '#ff9f89',
//                rendering: 'background',
//            },
//            {
//                start: '2016-05-06',
//                end: '2016-05-08',
//                overlap: false,
//                rendering: 'background',
//                color: '#ff9f89'
//            }
//        ]

    })
});
//$(window).on('load', function () {
//    $('#calendar').fullCalendar('render');
//});


