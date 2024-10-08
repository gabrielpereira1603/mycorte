<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Senha - MyCorte</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            background-color: #f3f4f6;
            padding: 20px;
        }

        .header img {
            max-width: 100%;
            height: auto;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 30px;
            text-align: center;
        }

        .content h1 {
            margin: 0 0 20px;
            color: #333333;
            font-size: 24px;
            font-weight: bold;
        }

        .content p {
            margin: 0 0 10px;
            color: #666666;
            font-size: 16px;
            line-height: 1.6;
        }

        .recovery-code {
            display: inline-block;
            margin: 20px 0;
        }

        .recovery-code span {
            display: inline-block;
            margin: 0 2px;
            padding: 10px 20px;
            font-size: 36px;
            color: #ffffff;
            background: linear-gradient(135deg, #858785, #c8cdc8);
            border-radius: 8px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            font-weight: bold;
            animation: bounce 0.3s ease-in-out infinite alternate;
        }

        .recovery-code .hyphen {
            margin: 0 5px;
            font-size: 36px;
            color: #ffffff;
        }

        @keyframes bounce {
            0% { transform: translateY(0); }
            100% { transform: translateY(-10px); }
        }

        .footer {
            padding: 20px;
            text-align: center;
            background-color: #f3f4f6;
            font-size: 14px;
            color: #aaaaaa;
        }

        /* Media query for small screens */
        @media (max-width: 600px) {
            .recovery-code span {
                font-size: 24px;
                padding: 5px 10px;
            }

            .hyphen{
                font-size: 24px;
                padding: 5px 10px;
            }
        }

        /* Dark mode styles */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #1a1a1a;
                color: #e0e0e0;
            }

            .container {
                background-color: #333333;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            }

            .content h1 {
                color: #ffffff;
            }

            .content p {
                color: #cccccc;
            }

            .header img {
                content: url('https://i.postimg.cc/dtg7Gf8v/logo-Letra-Branca.png'); /* Substitua pela URL da imagem do tema escuro */
            }
        }

        /* Light mode styles */
        @media (prefers-color-scheme: light) {
            .header img {
                content: url('https://i.postimg.cc/K8ZHYg6h/logo-Letra-Azul.png'); /* Substitua pela URL da imagem do tema claro */
            }
        }
    </style>
</head>

<body>
<div class="container">
    <div class="header">
        <img src="https://i.postimg.cc/K8ZHYg6h/logo-Letra-Azul.png" alt="MyCorte" width="250">
    </div>
    <div class="content">
        <h1>Recuperação de Senha</h1>
        <p>Olá, {{ $clientName }}!</p>
        <p>Você solicitou a recuperação de senha para sua conta no MyCorte.</p>
        <p>Seu código de recuperação é:</p>
        <div class="recovery-code">
            <?php
            $characters = str_split($recoveryCode);
            $length = count($characters);
            for ($i = 0; $i < $length; $i++) {
                echo "<span>{$characters[$i]}</span>";
                if (($i + 1) % 3 == 0 && $i + 1 != $length) {
                    echo "<span class='hyphen'>-</span>";
                }
            }
            ?>
        </div>
        <p>Por favor, utilize este código para redefinir sua senha.</p>
        <p>Se você não solicitou a recuperação de senha, ignore este email.</p>
        <p>Atenciosamente,<br>Equipe MyCorte</p>
    </div>
    <div class="footer">
        &copy; 2024 MyCorte. Todos os direitos reservados.
    </div>
</div>
</body>
</html>
