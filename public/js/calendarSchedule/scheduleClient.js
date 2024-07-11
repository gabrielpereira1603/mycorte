function initializeCalendar(scheduleId, collaboratorId, companyId, companyToken, formAction, token, redirectController) {
    var calendarEl = document.getElementById('calendar');
    var today = new Date();
    var URL = 'https://mycorte.somosdevteam.com';

    // Cache para armazenar os dados
    var availabilityCache = null;
    var scheduleCache = {};

    // Função para obter o nome do dia da semana em português
    function getDayName(date) {
        var days = ['Domingo', 'Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado'];
        return days[date.getDay()];
    }

    // Função para ajustar o calendário com base na disponibilidade do colaborador
    function adjustCalendar(availabilities) {
        var validDays = {};
        var slotDurations = {};
        var hiddenDays = [0, 1, 2, 3, 4, 5, 6]; // Todos os dias da semana, 0 é domingo, 6 é sábado

        // Acessa diretamente o array de disponibilidades
        availabilities.data.forEach(function(availability) {
            var day = availability.workDays;
            validDays[day] = {
                start: availability.hourStart.substr(0, 5), // Formato HH:MM
                end: availability.hourFinal.substr(0, 5)    // Formato HH:MM
            };
            slotDurations[day] = availability.hourServiceInterval; // Intervalo de serviço para cada dia

            // Remove o dia da semana da lista de dias ocultos
            var dayIndex = getDayIndex(day);
            var hiddenDayIndex = hiddenDays.indexOf(dayIndex);
            if (hiddenDayIndex > -1) {
                hiddenDays.splice(hiddenDayIndex, 1);
            }
        });

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridDay',
            locale: 'pt-br',
            height: 'auto',
            expandRows: true,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridDay'
            },
            hiddenDays: hiddenDays, // Oculta os dias da semana sem disponibilidade
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
                meridiem: false // Não adiciona AM/PM aos horários
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                var dateStr = fetchInfo.start.toISOString().slice(0, 10);

                // Verifique se os dados já estão no cache
                if (scheduleCache[dateStr]) {
                    successCallback(scheduleCache[dateStr]);
                    return;
                }

                // Buscar agendamentos e disponibilidades em paralelo
                Promise.all([
                    fetch(`${URL}/api/schedule/data/${dateStr}/${companyId}/${collaboratorId}`).then(response => response.json()),
                    fetch(`${URL}/api/availabilityCollaborator/collaborator/${collaboratorId}`).then(response => response.json()),
                    fetch(`${URL}/api/intervalCollaborator/collaborator/${collaboratorId}`).then(response => response.json())
                ]).then(([agendas, availabilities, intervals]) => {
                    var now = new Date();
                    var nowTime = getCurrentDateTime();
                    var start = new Date(dateStr + 'T00:00:00');
                    var startTime = start.toISOString().slice(0, 16);

                    var agendaEvents = agendas.data.map(agenda => {
                        var startDateTime = new Date(dateStr + 'T' + agenda.hourStart);
                        var status = agenda.status_schedule.status; // Acessa o status através do relacionamento status_schedule
                        var isScheduled = status === 'Agendado';
                        var isCanceled = status === 'Cancelado';
                        var eventColor = '#ff9f89'; // Cor para agendamentos por padrão
                        var eventTitle = status;

                        if (isScheduled) {
                            eventColor = '#ff9f89'; // Cor para agendamentos
                            eventTitle = 'Agendado';
                        } else if (isCanceled) {
                            return null; // Ignora eventos cancelados
                        } else {
                            // Verifica se há algum agendamento com status "Agendado" para este horário
                            var hasScheduled = agendas.data.some(a => {
                                return a.status_schedule.status === 'Agendado' && a.hourStart === agenda.hourStart && a.hourFinal === agenda.hourFinal;
                            });

                            if (hasScheduled) {
                                return null; // Ignora eventos que estão parcialmente ocupados por "Agendado"
                            }

                            eventColor = '#4CAF50'; // Cor para horários disponíveis se nenhum agendamento estiver agendado
                            eventTitle = 'Disponível';
                        }

                        return {
                            title: eventTitle,
                            start: dateStr + 'T' + agenda.hourStart,
                            end: dateStr + 'T' + agenda.hourFinal,
                            color: eventColor,
                            editable: false, // Desabilita a edição dos eventos
                            durationEditable: false // Desabilita a edição da duração dos eventos
                        };
                    }).filter(event => event !== null);



                    // Adiciona eventos de intervalos
                    var intervalEvents = intervals.data.map(interval => {
                        var intervalDate = interval.date; // Ajuste para acessar corretamente a data
                        if (intervalDate === dateStr) {
                            return {
                                title: 'Indisponível',
                                start: dateStr + 'T' + interval.hourStart,
                                end: dateStr + 'T' + interval.hourFinal,
                                color: '#D3D3D3', // Cor para intervalos
                                editable: false, // Desabilita a edição dos eventos
                                durationEditable: false // Desabilita a edição da duração dos eventos
                            };
                        }
                        return null;
                    }).filter(event => event !== null);


                    var allDayEvents = [];
                    var start = new Date(dateStr + 'T00:00:00');
                    var end = new Date(dateStr + 'T23:59:59');

                    while (start < end) {
                        var dayName = getDayName(start);
                        var startTime = start.toISOString().slice(0, 16);
                        var endTime = new Date(start.getTime() + parseDuration(slotDurations[dayName])).toISOString().slice(0, 16);
                        var nowTime = getCurrentDateTime();

                        // Verifica se o horário está ocupado
                        var isOccupied = agendaEvents.some(event => {
                            var eventStartTime = event.start.slice(0, 16); // Comparar apenas YYYY-MM-DDTHH:MM
                            var eventEndTime = event.end.slice(0, 16); // Comparar apenas YYYY-MM-DDTHH:MM
                            return eventStartTime <= startTime && eventEndTime >= endTime;
                        });

                        var isInterval = intervalEvents.some(event => {
                            var eventStartTime = event.start.slice(0, 16); // Comparar apenas YYYY-MM-DDTHH:MM
                            var eventEndTime = event.end.slice(0, 16); // Comparar apenas YYYY-MM-DDTHH:MM
                            return eventStartTime <= startTime && eventEndTime >= endTime;
                        });

                        var eventColor = '#4CAF50';
                        var eventTitle = 'Disponível';

                        if (startTime < nowTime) {
                            eventColor = '#D3D3D3'; // Cor para horários passados
                            eventTitle = 'Indisponível para agendamento';
                        }

                        if (!isOccupied && !isInterval) {
                            allDayEvents.push({
                                title: eventTitle,
                                start: startTime,
                                end: endTime,
                                color: eventColor,
                                editable: false, // Desabilita a edição dos eventos
                                durationEditable: false // Desabilita a edição da duração dos eventos
                            });
                        }

                        start = new Date(start.getTime() + parseDuration(slotDurations[dayName])); // Avança para o próximo slot
                    }

                    // Combina eventos de agendamentos e disponibilidades
                    var allEvents = agendaEvents.concat(intervalEvents).concat(allDayEvents);

                    // Armazena no cache
                    scheduleCache[dateStr] = allEvents;

                    successCallback(allEvents);
                }).catch(error => {
                    console.error('Erro ao buscar eventos:', error);
                    failureCallback(error);
                });
            },
            customButtons: {
                prev: {
                    click: function () {
                        var currentDate = calendar.getDate();
                        if (currentDate > today) {
                            calendar.prev();
                        }
                    }
                },
                next: {
                    click: function () {
                        var currentDate = calendar.getDate();
                        var limitDate = new Date(today);
                        limitDate.setDate(today.getDate() + 6);
                        if (currentDate < limitDate) {
                            calendar.next();
                        }
                    }
                }
            },
            datesSet: function (dateInfo) {
                var dayName = getDayName(dateInfo.start);
                if (validDays[dayName]) {
                    calendar.setOption('slotMinTime', validDays[dayName].start);
                    calendar.setOption('slotMaxTime', validDays[dayName].end);
                } else {
                    calendar.setOption('slotMinTime', '00:00:00');
                    calendar.setOption('slotMaxTime', '24:00:00');
                }
            },
            dateClick: function(info) {},
            eventClick: function(info) {
                var clickedEvent = info.event;

                // Verifica se o evento clicado é 'Disponível' e se a data/hora atual é menor que a data/hora do evento
                if (clickedEvent.title === 'Disponível' && new Date() < clickedEvent.start) {
                    var start = clickedEvent.startStr.slice(11, 16); // Extrai apenas a hora de início (HH:MM)
                    var end = clickedEvent.endStr.slice(11, 16); // Extrai apenas a hora de fim (HH:MM)
                    var date = clickedEvent.start.toISOString().slice(0, 10); // Apenas a data no formato YYYY-MM-DD


                    redirectToServiceClient(start,end,date,collaboratorId,companyToken, 'serviceBySchedule');
                }
            }
        });

        calendar.render();
    }

    function redirectToServiceClient(start, end, date, collaboratorId, companyToken, redirectRoute) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = formAction; // Nome da rota que irá armazenar os dados na sessão e redirecionar

        var csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = token; // Aqui você insere o token CSRF dinamicamente
        form.appendChild(csrfToken);

        var idSchedule = document.createElement('input');
        idSchedule.type = 'hidden';
        idSchedule.name = 'scheduleId';
        idSchedule.value = scheduleId;
        form.appendChild(idSchedule);

        var ControllerRedirect = document.createElement('input');
        ControllerRedirect.type = 'hidden';
        ControllerRedirect.name = 'redirectController';
        ControllerRedirect.value = redirectController; // Aqui você insere o token CSRF dinamicamente
        form.appendChild(ControllerRedirect);

        var redirectRouteInput = document.createElement('input');
        redirectRouteInput.type = 'hidden';
        redirectRouteInput.name = 'redirectRoute';
        redirectRouteInput.value = redirectRoute;
        form.appendChild(redirectRouteInput);

        var tokenCompanyInput = document.createElement('input');
        tokenCompanyInput.type = 'hidden';
        tokenCompanyInput.name = 'tokenCompany';
        tokenCompanyInput.value = companyToken;
        form.appendChild(tokenCompanyInput);

        var startInput = document.createElement('input');
        startInput.type = 'hidden';
        startInput.name = 'start';
        startInput.value = start;
        form.appendChild(startInput);

        var endInput = document.createElement('input');
        endInput.type = 'hidden';
        endInput.name = 'end';
        endInput.value = end;
        form.appendChild(endInput);

        var dateInput = document.createElement('input');
        dateInput.type = 'hidden';
        dateInput.name = 'date';
        dateInput.value = date;
        form.appendChild(dateInput);

        var collaboratorIdInput = document.createElement('input');
        collaboratorIdInput.type = 'hidden';
        collaboratorIdInput.name = 'collaboratorId';
        collaboratorIdInput.value = collaboratorId;
        form.appendChild(collaboratorIdInput);

        document.body.appendChild(form);
        form.submit();
    }

    // Função para converter a duração do intervalo de serviço em milissegundos
    function parseDuration(duration) {
        var parts = duration.split(':');
        return (parseInt(parts[0], 10) * 60 * 60 * 1000) + (parseInt(parts[1], 10) * 60 * 1000);
    }

    //função para obter a data atual do usuário no formato StartTime
    //para poder fazer a validação de horários
    function getCurrentDateTime() {
        var now = new Date();

        var year = now.getFullYear();
        var month = (now.getMonth() + 1).toString().padStart(2, '0'); // Meses são indexados a partir de 0
        var day = now.getDate().toString().padStart(2, '0');

        var hours = now.getHours().toString().padStart(2, '0');
        var minutes = now.getMinutes().toString().padStart(2, '0');

        var formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        return formattedDateTime;
    }

    // Função para obter o índice do dia da semana a partir do nome do dia
    function getDayIndex(dayName) {
        var days = {
            'Domingo': 0,
            'Segunda': 1,
            'Terca': 2,
            'Quarta': 3,
            'Quinta': 4,
            'Sexta': 5,
            'Sabado': 6
        };
        return days[dayName];
    }

    // Função para buscar a disponibilidade do colaborador da API
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

    // Buscar a disponibilidade do colaborador ao carregar a página
    fetchAvailability();
}
