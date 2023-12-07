(function () {
    document.addEventListener("DOMContentLoaded", function () {
        /* initialize the external events
          -----------------------------------------------------------------*/

        var containerEl = document.getElementById("external-events-list");
        new FullCalendar.Draggable(containerEl, {
            itemSelector: ".fc-event",
            eventData: function (eventEl) {
                return {
                    title: eventEl.innerText.trim(),
                };
            },
        });

        //// the individual way to do it
        // var containerEl = document.getElementById('external-events-list');
        // var eventEls = Array.prototype.slice.call(
        //   containerEl.querySelectorAll('.fc-event')
        // );
        // eventEls.forEach(function(eventEl) {
        //   new FullCalendar.Draggable(eventEl, {
        //     eventData: {
        //       title: eventEl.innerText.trim(),
        //     }
        //   });
        // });

        /* initialize the calendar
          -----------------------------------------------------------------*/

        var calendarEl = document.getElementById("calendar");
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: "prev,next today",
                center: "Başlık",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
            },
            initialView: "dayGridMonth",
            initialDate: "2022-11-12",
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            selectable: true,
            nowIndicator: true,
            // dayMaxEvents: true, // allow "more" link when too many events
            events: [
                {
                    title: "All Day Event",
                    start: "2023-12-12",
                },
                {
                    title: "Tour with our Team.",
                    start: "2023-12-12",
                },
                {
                    title: "Meeting with Team",
                    start: "2023-12-12",
                },
                {
                    title: "Upload New Project",
                    start: "2023-12-12",
                },
                {
                    title: "Birthday Party",
                    start: "2023-12-12",

                },
                {
                    title: "Reporting about Theme",
                    start: "2023-12-12",

                },
                {
                    title: "Lunch",
                    start: "2023-12-12",
                },
                {
                    title: "Meeting",
                    start: "2023-12-12",
                },
                {
                    title: "Happy Hour",
                    start: "2023-12-12",
                },
            ],
        });
    });
})();
