<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo email capturado</title>
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
        <img src="https://i.postimg.cc/K8ZHYg6h/logo-Letra-Azul.png" alt="Novo email capturado">
    </div>
    <div class="content">
        <h1>Novo email capturado!</h1>
        <p>O email é: {{ $capturedEmail }}</p>
        <p>Entre em contato com o cliente o mais breve possível.</p>
    </div>
    <div class="footer">
        &copy; 2024 MyCorte. Todos os direitos reservados.
    </div>
</div>
</body>

</html>
