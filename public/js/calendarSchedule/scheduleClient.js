function initializeCalendar(scheduleId, collaboratorId, companyId, companyToken, formAction, token, redirectController) {
    const calendarEl = document.getElementById('calendar');
    const today = new Date();
    const URL = 'https://mycorte.somosdevteam.com';
    let availabilityCache = null;
    let scheduleCache = {};

    const DAYS = ['Domingo', 'Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado'];

    function getDayName(date) {
        return DAYS[date.getDay()];
    }

    function getDayIndex(dayName) {
        return DAYS.indexOf(dayName);
    }

    function parseDuration(duration) {
        const [hours, minutes] = duration.split(':').map(Number);
        return (hours * 60 * 60 * 1000) + (minutes * 60 * 1000);
    }

    function getCurrentDateTime() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        return `${year}-${month}-${day}T${hours}:${minutes}`;
    }

    function redirectToServiceClient(start, end, date, collaboratorId, companyToken, redirectRoute) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = formAction;

        const inputs = [
            { name: '_token', value: token },
            { name: 'scheduleId', value: scheduleId },
            { name: 'redirectController', value: redirectController },
            { name: 'redirectRoute', value: redirectRoute },
            { name: 'tokenCompany', value: companyToken },
            { name: 'start', value: start },
            { name: 'end', value: end },
            { name: 'date', value: date },
            { name: 'collaboratorId', value: collaboratorId }
        ];

        inputs.forEach(({ name, value }) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }

    function fetchAvailability() {
        if (availabilityCache) {
            adjustCalendar(availabilityCache);
            return;
        }

        fetch(`${URL}/api/availabilityCollaborator/collaborator/${collaboratorId}`)
            .then(response => response.json())
            .then(data => {
                availabilityCache = data;
                adjustCalendar(data);
            })
            .catch(error => {
                console.error('Erro ao buscar a disponibilidade do colaborador:', error);
            });
    }

    function adjustCalendar(availabilities) {
        const validDays = {};
        const slotDurations = {};
        const hiddenDays = [0, 1, 2, 3, 4, 5, 6];

        availabilities.data.forEach(availability => {
            const day = availability.workDays;
            validDays[day] = {
                start: availability.hourStart.substr(0, 5),
                end: availability.hourFinal.substr(0, 5)
            };
            slotDurations[day] = availability.hourServiceInterval;

            const dayIndex = getDayIndex(day);
            const hiddenDayIndex = hiddenDays.indexOf(dayIndex);
            if (hiddenDayIndex > -1) {
                hiddenDays.splice(hiddenDayIndex, 1);
            }
        });

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridDay',
            locale: 'pt-br',
            height: 'auto',
            expandRows: true,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridDay'
            },
            hiddenDays: hiddenDays,
            validRange: function(nowDate) {
                let endDate = new Date(nowDate);
                endDate.setDate(endDate.getDate() + 6);
                return { start: nowDate, end: endDate };
            },
            navLinks: false,
            nowIndicator: true,
            initialDate: today,
            slotLabelFormat: {
                hour: 'numeric',
                minute: '2-digit',
                meridiem: false
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                fetchEvents(fetchInfo, successCallback, failureCallback, slotDurations);
            },
            customButtons: {
                prev: {
                    click: function() {
                        const currentDate = calendar.getDate();
                        if (currentDate > today) {
                            calendar.prev();
                        }
                    }
                },
                next: {
                    click: function() {
                        const currentDate = calendar.getDate();
                        const limitDate = new Date(today);
                        limitDate.setDate(today.getDate() + 6);
                        if (currentDate < limitDate) {
                            calendar.next();
                        }
                    }
                }
            },
            datesSet: function(dateInfo) {
                const dayName = getDayName(dateInfo.start);
                if (validDays[dayName]) {
                    calendar.setOption('slotMinTime', validDays[dayName].start);
                    calendar.setOption('slotMaxTime', validDays[dayName].end);
                } else {
                    calendar.setOption('slotMinTime', '00:00:00');
                    calendar.setOption('slotMaxTime', '24:00:00');
                }
            },
            dateClick: function() {},
            eventClick: function(info) {
                const clickedEvent = info.event;
                if (clickedEvent.title === 'Disponível' && new Date() < clickedEvent.start) {
                    const start = clickedEvent.startStr.slice(11, 16);
                    const end = clickedEvent.endStr.slice(11, 16);
                    const date = clickedEvent.start.toISOString().slice(0, 10);
                    redirectToServiceClient(start, end, date, collaboratorId, companyToken, 'serviceBySchedule');
                }
            }
        });

        calendar.render();
    }

    function fetchEvents(fetchInfo, successCallback, failureCallback, slotDurations) {
        const dateStr = fetchInfo.start.toISOString().slice(0, 10);

        if (scheduleCache[dateStr]) {
            successCallback(scheduleCache[dateStr]);
            return;
        }

        Promise.all([
            fetch(`${URL}/api/schedule/data/${dateStr}/${companyId}/${collaboratorId}`).then(response => response.json()),
            fetch(`${URL}/api/availabilityCollaborator/collaborator/${collaboratorId}`).then(response => response.json()),
            fetch(`${URL}/api/intervalCollaborator/collaborator/${collaboratorId}`).then(response => response.json())
        ]).then(([agendas, availabilities, intervals]) => {
            const allEvents = processEvents(dateStr, agendas, availabilities, intervals, slotDurations);
            scheduleCache[dateStr] = allEvents;
            successCallback(allEvents);
        }).catch(error => {
            console.error('Erro ao buscar eventos:', error);
            failureCallback(error);
        });
    }

    function processEvents(dateStr, agendas, availabilities, intervals, slotDurations) {
        const agendaEvents = agendas.data.map(agenda => {
            const startDateTime = new Date(dateStr + 'T' + agenda.hourStart);
            const status = agenda.status_schedule.status;
            if (status === 'Cancelado') return null;
            if (status === 'Reagendado') return null;
            const eventColor = status === 'Agendado' ? '#ff9f89' : '#4CAF50';
            const eventTitle = status === 'Agendado' ? 'Agendado' : 'Disponível';
            return {
                title: eventTitle,
                start: dateStr + 'T' + agenda.hourStart,
                end: dateStr + 'T' + agenda.hourFinal,
                color: eventColor,
                editable: false,
                durationEditable: false
            };
        }).filter(event => event !== null);

        const intervalEvents = intervals.data.map(interval => {
            return {
                title: 'Indisponível',
                start: dateStr + 'T' + interval.hourStart,
                end: dateStr + 'T' + interval.hourFinal,
                color: '#D3D3D3',
                editable: false,
                durationEditable: false
            };
        });


        let lunchEvents = [];
        availabilities.data.forEach(availabilities => {
            const existingLunchEvent = lunchEvents.find(lunchEvent =>
                lunchEvent.start === dateStr + 'T' + availabilities.lunchTimeStart &&
                lunchEvent.end === dateStr + 'T' + availabilities.lunchTimeFinal
            );

            if (!existingLunchEvent) {
                lunchEvents.push({
                    title: 'Almoço',
                    start: dateStr + 'T' + availabilities.lunchTimeStart,
                    end: dateStr + 'T' + availabilities.lunchTimeFinal,
                    color: '#FFD700',
                    editable: false,
                    durationEditable: false
                });
            }
        });

        console.log(lunchEvents)

        const allDayEvents = createAllDayEvents(dateStr, agendaEvents, intervalEvents, slotDurations, lunchEvents);

        return [...agendaEvents, ...intervalEvents, ...lunchEvents, ...allDayEvents];
    }

    function createAllDayEvents(dateStr, agendaEvents, intervalEvents, slotDurations, lunchEvents) {
        const allDayEvents = [];
        let start = new Date(dateStr + 'T00:00:00');
        const end = new Date(dateStr + 'T23:59:59');

        while (start < end) {
            const dayName = getDayName(start);
            const startTime = start.toISOString().slice(0, 16);
            const endTime = new Date(start.getTime() + parseDuration(slotDurations[dayName])).toISOString().slice(0, 16);
            const nowTime = getCurrentDateTime();

            const isOccupied = agendaEvents.some(event => {
                const eventStartTime = event.start.slice(0, 16);
                const eventEndTime = event.end.slice(0, 16);
                return eventStartTime <= startTime && eventEndTime >= endTime;
            });

            const isInterval = intervalEvents.some(event => {
                const eventStartTime = event.start.slice(0, 16);
                const eventEndTime = event.end.slice(0, 16);
                console.log(eventStartTime)

                return eventStartTime <= startTime && eventEndTime >= endTime;
            });

            const lunchEvent = lunchEvents.find(event => {
                const eventStartTime = event.start.slice(0, 16);
                const eventEndTime = event.end.slice(0, 16);
                return eventStartTime <= startTime && eventEndTime >= endTime;
            });

            const eventColor = startTime < nowTime ? '#D3D3D3' : '#4CAF50';
            const eventTitle = startTime < nowTime ? 'Indisponível para agendamento' : 'Disponível';

            if (!isOccupied && !isInterval && !lunchEvent) {
                allDayEvents.push({
                    title: eventTitle,
                    start: startTime,
                    end: endTime,
                    color: eventColor,
                    editable: false,
                    durationEditable: false
                });
            }

            start = new Date(start.getTime() + parseDuration(slotDurations[dayName]));
        }

        return allDayEvents;
    }

    fetchAvailability();
}
