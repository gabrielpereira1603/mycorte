<!-- resources/views/Client/mycutsClient.blade.php -->
<x-layoutClient title="Meus Cortes" :tokenCompany="$tokenCompany">
    <div class="profile-name" style="background-color: #3a497684; text-align: center; padding: 20px 0;">
        <h3 style="color: white; margin: 0;">Meus Agendamentos</h3>
    </div>

    <section class="section-myCuts">
        <div class="main-myCuts">
            @if($schedules->isEmpty())
                <p class="no-schedules">Você não tem agendamentos.</p>
            @else
                @foreach($schedules as $schedule)
                    <div class="card-schedule">
                        <div class="info-schedule">
                            <h4>Agendamento em {{ $schedule->date }} às {{ $schedule->hourStart }}</h4>
                            <p><strong>Hora de Término:</strong> {{ $schedule->hourFinal }}</p>
                            <p><strong>Status:</strong> Agendado</p>
                        </div>
                        <div class="services-schedule">
                            <h5>Serviços:</h5>
                            <ul>
                                @foreach($schedule->services as $service)
                                    <li>{{ $service->name }} - R$ {{ number_format($service->value, 2, ',', '.') }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <style>
        .profile-name {
            background-color: #3a497684;
            text-align: center;
            padding: 20px 0;
        }

        .section-myCuts {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
            background-color: #f1f1f1;
        }

        .main-myCuts {
            width: 80%;
            max-width: 1200px;
        }

        .no-schedules {
            text-align: center;
            font-size: 1.2em;
            color: #777;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-schedule {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card-schedule:hover {
            transform: translateY(-5px);
        }

        .info-schedule h4 {
            margin: 0 0 10px 0;
            font-size: 1.5em;
            color: #333;
        }

        .info-schedule p {
            margin: 5px 0;
            font-size: 1.1em;
            color: #555;
        }

        .services-schedule h5 {
            margin: 20px 0 10px;
            font-size: 1.3em;
            color: #333;
        }

        .services-schedule ul {
            list-style-type: none;
            padding: 0;
        }

        .services-schedule ul li {
            background-color: #eaeaea;
            border-radius: 5px;
            padding: 10px;
            margin: 5px 0;
            font-size: 1.1em;
            color: #333;
            transition: background-color 0.3s ease;
        }

        .services-schedule ul li:hover {
            background-color: #d4d4d4;
        }
    </style>
</x-layoutClient>
