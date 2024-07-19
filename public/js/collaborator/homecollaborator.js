var toasts = document.querySelectorAll('.toast');
var remindClientButtons = document.querySelectorAll('.remind-client-btn');

// Inicializa os toasts existentes
toasts.forEach(function(toast) {
    var bsToast = new bootstrap.Toast(toast, {
        autohide: false,
    });
    bsToast.show();
});

remindClientButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var scheduleId = this.getAttribute('data-schedule-id');
        sendReminderEmail(scheduleId);
    });
});

function sendReminderEmail(scheduleId) {
    fetch(`/send-reminder/${scheduleId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            scheduleId: scheduleId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Lembrete enviado com sucesso!');
            } else {
                alert('Falha ao enviar lembrete.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
}
