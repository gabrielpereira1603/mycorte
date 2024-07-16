<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
        <link rel="stylesheet" href="{{ asset('css/allCompany.css') }}">
        <link rel="stylesheet" href="{{ asset('css/aboutClient.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>Sobre Nós</title>
    </head>
    <body>
        <header>
            <nav class="nav-allcompany">
                <img src="{{ asset('favicon.png') }}" alt="Logo MyCuts">
            </nav>
        </header>

        <section class="about-us">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="title" data-aos="fade-down">Sobre a MyCorte</h1>
                        <p class="subtitle" data-aos="fade-up">Conheça mais sobre a nossa empresa, nossos valores, visão e as vantagens que oferecemos.</p>
                    </div>
                </div>
                <div class="row d-flex flex-column flex-md-row align-items-center">
                    <div class="col-md-6" data-aos="fade-right">
                        <div class="card shadow p-3 mb-5 bg-white rounded">
                            <h2 class="section-title">Quem Somos</h2>
                            <p>Somos uma empresa dedicada a facilitar o agendamento de serviços de beleza e bem-estar. Nosso objetivo é proporcionar uma experiência simples e eficiente para nossos clientes, conectando-os com profissionais qualificados.</p>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <div class="card shadow p-3 mb-5 bg-white rounded">
                            <img src="https://images.pexels.com/photos/6146929/pexels-photo-6146929.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="Nossa Empresa" class="img-fluid responsive-img">
                        </div>
                    </div>
                </div>
                <div class="row d-flex flex-column flex-md-row align-items-center">
                    <div class="col-md-6 order-md-2" data-aos="fade-left">
                        <div class="card shadow p-3 mb-5 bg-white rounded">
                            <h2 class="section-title">Nossos Valores</h2>
                            <ul class="values-list">
                                <li><strong>Excelência:</strong> Nos esforçamos para oferecer os melhores serviços aos nossos clientes.</li>
                                <li><strong>Inovação:</strong> Estamos sempre buscando maneiras inovadoras de melhorar nossos serviços.</li>
                                <li><strong>Comprometimento:</strong> Comprometidos com a satisfação de nossos clientes e colaboradores.</li>
                                <li><strong>Integridade:</strong> Atuamos com transparência e ética em todas as nossas ações.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 order-md-1" data-aos="fade-right">
                        <div class="card shadow p-3 mb-5 bg-white rounded">
                            <img src="https://images.pexels.com/photos/3268732/pexels-photo-3268732.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="Nossos Valores" class="img-fluid responsive-img">
                        </div>
                    </div>
                </div>
                <div class="row d-flex flex-column flex-md-row align-items-center">
                    <div class="col-md-6" data-aos="fade-right">
                        <div class="card shadow p-3 mb-5 bg-white rounded">
                            <h2 class="section-title">Nossa Visão</h2>
                            <p>Ser a principal plataforma de agendamento de serviços de beleza e bem-estar, reconhecida pela qualidade e inovação de nossos serviços, e pela satisfação de nossos clientes e colaboradores.</p>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <div class="card shadow p-3 mb-5 bg-white rounded">
                            <img src="https://images.pexels.com/photos/1813272/pexels-photo-1813272.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="Nossa Visão" class="img-fluid responsive-img">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center" data-aos="fade-up">
                        <div class="card shadow p-3 mb-5 bg-white rounded">
                            <h2 class="section-title">Vantagens do MyCorte</h2>
                            <ul class="advantages-list">
                                <li><strong>Agendamento Fácil:</strong> Interface intuitiva para agendar serviços rapidamente.</li>
                                <li><strong>Profissionais Qualificados:</strong> Conexão com os melhores profissionais da área.</li>
                                <li><strong>Gestão de Agendamentos:</strong> Ferramentas avançadas para gerenciar e acompanhar seus agendamentos.</li>
                                <li><strong>Notificações em Tempo Real:</strong> Receba lembretes e atualizações instantâneas.</li>
                                <li><strong>Suporte ao Cliente:</strong> Atendimento dedicado para resolver suas dúvidas e problemas.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('Client.Footer.footerClient')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </body>
</html>
