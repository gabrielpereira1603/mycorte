<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/allCompany.css') }}">
    <link rel="stylesheet" href="{{ asset('css/termsOfUse.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Termos de Uso</title>
</head>
<body>
<header>
    <nav class="nav-allcompany">
        <img src="{{ asset('favicon.png') }}" alt="Logo MyCuts">
    </nav>
</header>

<section class="terms-of-use">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="title" data-aos="fade-down">Termos de Uso</h1>
                <p class="subtitle" data-aos="fade-up">Entenda as condições e responsabilidades ao utilizar nossa plataforma.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow p-3 mb-4 bg-white rounded" data-aos="fade-right">
                    <h2 class="section-title">Aceitação dos Termos</h2>
                    <p>Ao utilizar nossa plataforma, você concorda com os presentes Termos de Uso. Se você não concorda com qualquer parte destes termos, não deverá utilizar nossos serviços.</p>
                    <p>Estes termos podem ser atualizados periodicamente, e recomendamos que você revise esta página regularmente para estar ciente de quaisquer alterações.</p>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow p-3 mb-4 bg-white rounded" data-aos="fade-left">
                    <h2 class="section-title">Uso da Plataforma</h2>
                    <p>Você se compromete a utilizar a plataforma de maneira ética e responsável, respeitando as leis aplicáveis e os direitos de terceiros. É proibido:</p>
                    <ul class="usage-rules-list">
                        <li>Usar a plataforma para fins ilegais ou não autorizados.</li>
                        <li>Transmitir qualquer tipo de conteúdo ofensivo, abusivo ou que viole os direitos de terceiros.</li>
                        <li>Tentar hackear, alterar ou comprometer a segurança da plataforma.</li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow p-3 mb-4 bg-white rounded" data-aos="fade-right">
                    <h2 class="section-title">Conta de Usuário</h2>
                    <p>Para utilizar certos recursos da plataforma, você precisará criar uma conta. Você é responsável por manter a confidencialidade de suas informações de login e por todas as atividades que ocorram sob sua conta.</p>
                    <ul class="account-rules-list">
                        <li>Mantenha suas informações de conta precisas e atualizadas.</li>
                        <li>Notifique-nos imediatamente em caso de uso não autorizado de sua conta.</li>
                        <li>Não compartilhe suas informações de login com terceiros.</li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow p-3 mb-4 bg-white rounded" data-aos="fade-left">
                    <h2 class="section-title">Propriedade Intelectual</h2>
                    <p>Todo o conteúdo e material disponível na plataforma, incluindo textos, gráficos, logotipos, ícones, imagens, clipes de áudio, downloads digitais e software, são de propriedade exclusiva da MyCorte ou de seus licenciadores e são protegidos pelas leis de direitos autorais e outras leis de propriedade intelectual.</p>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow p-3 mb-4 bg-white rounded" data-aos="fade-right">
                    <h2 class="section-title">Limitação de Responsabilidade</h2>
                    <p>A MyCorte não será responsável por quaisquer danos diretos, indiretos, incidentais, consequenciais ou punitivos decorrentes do uso ou da incapacidade de usar a plataforma, incluindo, sem limitação, perda de lucros, perda de dados ou interrupção dos negócios.</p>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow p-3 mb-4 bg-white rounded" data-aos="fade-left">
                    <h2 class="section-title">Privacidade e Proteção de Dados</h2>
                    <p>Estamos comprometidos em proteger sua privacidade e seus dados pessoais. Consulte nossa <a href="{{ route('privacy-policy') }}">Política de Privacidade</a> para obter mais informações sobre como coletamos, usamos e protegemos suas informações.</p>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow p-3 mb-4 bg-white rounded" data-aos="fade-right">
                    <h2 class="section-title">Modificações nos Termos</h2>
                    <p>Reservamo-nos o direito de modificar estes Termos de Uso a qualquer momento. As mudanças entrarão em vigor imediatamente após sua publicação na plataforma. Seu uso continuado da plataforma após a publicação das alterações constitui sua aceitação dos novos termos.</p>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow p-3 mb-4 bg-white rounded" data-aos="fade-left">
                    <h2 class="section-title">Contato</h2>
                    <p>Se você tiver dúvidas ou preocupações sobre estes Termos de Uso, por favor, entre em contato conosco. Estamos à disposição para ajudar.</p>
                    <ul class="contact-list">
                        <li><strong>E-mail:</strong> suporte@somosdevteam.com.br</li>
                        <li><strong>Telefone:</strong> (67) 98195-7833 ou (17) 98202-6102</li>
                        <li><strong>Endereço:</strong> Santa Fé do Sul, SP, Brasil</li>
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
