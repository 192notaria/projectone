document.addEventListener('DOMContentLoaded', function() {

    // Date variable
    var newDate = new Date();

    function getDynamicMonth() {
        getMonthValue = newDate.getMonth();
        if (getMonthValue < 10) {
            return `0${getMonthValue+1}`;
        } else {
            return `${getMonthValue+1}`;
        }
    }

    var getModalTitleEl = document.querySelector('#event-title');
    var getModalStartDateEl = document.querySelector('#event-start-date');
    var getModalEndDateEl = document.querySelector('#event-end-date');
    var getModalAddBtnEl = document.querySelector('.btn-add-event');
    var getModalUpdateBtnEl = document.querySelector('.btn-update-event');

    var calendarsEvents = {
        Work: 'primary',
        Personal: 'success',
        Important: 'danger',
        ChangeGuard: 'warning',
    }

    // Calendar Elements and options
    var calendarEl = document.querySelector('.calendar');

    var checkWidowWidth = function() {
        if (window.innerWidth <= 1199) {
            return true;
        } else {
            return false;
        }
    }

    var calendarHeaderToolbar = {
        left: 'prev next',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    }
    var calendarEventsList = [
        {
            id: 1,
            title: 'All Day Event',
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-01`,
            extendedProps: { calendar: 'Work' }
        },
        {
            id: 2,
            title: 'Long Event',
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-07`,
            end: `${newDate.getFullYear()}-${getDynamicMonth()}-10`,
            extendedProps: { calendar: 'Personal' }
        },
        {
            groupId: '999',
            id: 3,
            title: 'Repeating Event',
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-09T16:00:00`,
            extendedProps: { calendar: 'Important' }
        },
        {
            groupId: '999',
            id: 4,
            title: 'Repeating Event',
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-16T16:00:00`,
            extendedProps: { calendar: 'Travel' }
        },
        {
            id: 5,
            title: 'Conference',
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-11`,
            end: `${newDate.getFullYear()}-${getDynamicMonth()}-13`,
            extendedProps: { calendar: 'Work' }
        },
        {
            id: 6,
            title: 'Meeting',
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T10:30:00`,
            end: `${newDate.getFullYear()}-${getDynamicMonth()}-12T12:30:00`,
            extendedProps: { calendar: 'Personal' }
        },
        {
            id: 7,
            title: 'Lunch',
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T12:00:00`,
            extendedProps: { calendar: 'Important' }
        },
        {
            id: 8,
            title: 'Meeting',
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T14:30:00`,
            extendedProps: { calendar: 'Travel' }
        },
        {
            id: 9,
            title: 'Birthday Party',
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-13T07:00:00`,
            extendedProps: { calendar: 'Personal' }
        },
        {
            id: 10,
            title: 'Click for Google',
            url: 'http://google.com/',
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-28`,
            extendedProps: { calendar: 'Important' }
        }
    ]
    var eventsdata = "http://projectone.test/usuarios/getGuardias"
    // var eventsdata = "http://192.168.1.100/usuarios/getGuardias"

    // Calendar Select fn.
    var calendarSelect = function(info) {
        getModalAddBtnEl.style.display = 'block';
        getModalUpdateBtnEl.style.display = 'none';
        myModal.show()
        getModalStartDateEl.value = info.startStr;
        getModalEndDateEl.value = info.endStr;
    }

    // Calendar AddEvent fn.
    var calendarAddEvent = function() {
        var currentDate = new Date();
        var dd = String(currentDate.getDate()).padStart(2, '0');
        var mm = String(currentDate.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = currentDate.getFullYear();
        var combineDate = `${yyyy}-${mm}-${dd}T00:00:00`;
        getModalAddBtnEl.style.display = 'block';
        getModalUpdateBtnEl.style.display = 'none';
        myModal.show();
        getModalStartDateEl.value = combineDate;
    }

    // Calendar eventClick fn.
    var calendarEventClick = function(info) {
        var eventObj = info.event;

        if (eventObj.url) {
          window.open(eventObj.url);
          info.jsEvent.preventDefault();
        } else {
            // var getModalEventId = eventObj._def.publicId;
            // var getModalEventLevel = eventObj._def.extendedProps['calendar'];
            // var getModalCheckedRadioBtnEl = document.querySelector(`input[value="${getModalEventLevel}"]`);
            // getModalTitleEl.innerHTML = "¿Seguro que desea solicitar un cambio de guardia con <span class='fw-bold'>" + eventObj.title + "</span>?"
            Livewire.emit('modalcambiodeguardia', eventObj.title, eventObj.id, eventObj.start)
            // getModalCheckedRadioBtnEl.checked = true;
            // getModalUpdateBtnEl.setAttribute('data-fc-event-public-id', getModalEventId)
            // getModalAddBtnEl.style.display = 'none';
            // getModalUpdateBtnEl.style.display = 'block';
            myModal.show();
        }
    }

    // Activate Calender
    var calendar = new FullCalendar.Calendar(calendarEl, {
        selectable: true,
        // height: checkWidowWidth() ? 900 : 1052,
        // initialView: checkWidowWidth() ? 'listWeek' : 'dayGridMonth',
        initialDate: `${newDate.getFullYear()}-${getDynamicMonth()}-07`,
        headerToolbar: calendarHeaderToolbar,
        locale: 'es',
        events: eventsdata,
        eventClassNames: function ({ event: calendarEvent }) {
            const getColorValue = calendarsEvents[calendarEvent._def.extendedProps.calendar];
            return [
              // Background Color
              'event-fc-color fc-bg-' + getColorValue
            ];
        },

        eventClick: calendarEventClick,
        // windowResize: function(arg) {
        //     if (checkWidowWidth()) {
        //         calendar.changeView('listWeek');
        //         calendar.setOption('height', 900);
        //     } else {
        //         calendar.changeView('dayGridMonth');
        //         calendar.setOption('height', 1052);
        //     }
        // }
    });




    // Update Event
    getModalUpdateBtnEl.addEventListener('click', function() {
        var getPublicID = this.dataset.fcEventPublicId;
        var getTitleUpdatedValue = getModalTitleEl.value;
        var getEvent = calendar.getEventById(getPublicID);
        var getModalUpdatedCheckedRadioBtnEl = document.querySelector('input[name="event-level"]:checked');

        var getModalUpdatedCheckedRadioBtnValue = (getModalUpdatedCheckedRadioBtnEl !== null) ? getModalUpdatedCheckedRadioBtnEl.value : '';

        getEvent.setProp('title', getTitleUpdatedValue);
        getEvent.setExtendedProp('calendar', getModalUpdatedCheckedRadioBtnValue);
        myModal.hide()
    })

    // Calendar Renderation
    calendar.render();

    // Add Event
    window.addEventListener('solicitud-de-cambio', event => {
        myModal.hide()
        calendar.refetchEvents()

    })
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'))
    var modalToggle = document.querySelector('.fc-addEventButton-button ')

    document.getElementById('exampleModal').addEventListener('hidden.bs.modal', function (event) {
        var getModalIfCheckedRadioBtnEl = document.querySelector('input[name="event-level"]:checked');
        if (getModalIfCheckedRadioBtnEl !== null) { getModalIfCheckedRadioBtnEl.checked = false; }
    })
});
