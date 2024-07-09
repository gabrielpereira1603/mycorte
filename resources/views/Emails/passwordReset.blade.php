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
            background-color: #151a21;
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
            padding: 10px 20px;
            font-size: 36px;
            color: #ffffff;
            background: linear-gradient(135deg, #4CAF50, #81C784);
            border-radius: 8px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            font-weight: bold;
        }

        .footer {
            padding: 20px;
            text-align: center;
            background-color: #f3f4f6;
            font-size: 14px;
            color: #aaaaaa;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="header">
        <img src="https://i.postimg.cc/RCDV18qy/temp-Imageh1yvji.avif" alt="MyCorte">
    </div>
    <div class="content">
        <h1>Recuperação de Senha</h1>
        <p>Olá, {{ $clientName }}!</p>
        <p>Você solicitou a recuperação de senha para sua conta no MyCorte.</p>
        <p>Seu código de recuperação é:</p>
        <div class="recovery-code">
            {{ $recoveryCode }}
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
