<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Redefinir Senha</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('/img/app/logo/logo.png') }}" alt="logo" width="250">
        </div>
        <div class="content">
            <h2>Redefinição de Senha</h2>
            <p>Você está recebendo este e-mail porque solicitou uma redefinição de senha para sua conta.</p>
            <p>Caso deseje prosseguir, clique no botão abaixo para redefinir sua senha:</p>
            <a href="{{ $url }}" class="button">Redefinir Senha</a>
            <p>O link irá expirar em 60 minutos. Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.</p>
            <p>Atenciosamente,<br>Equipe {{ config('app.name') }}</p>
        </div>
        <div class="footer">
            <hr>
            <div>
                <p class="reset-url">Se você não estiver conseguindo utilizar o botão "Redefinir Senha", clique no link abaixo ou copie e cole no seu navegador: <a href="{{ $url }}">{{ $url }}</a></p>
            </div>
            <p class=copyright>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 100%;
        padding: 20px;
        background-color: #fff;
        max-width: 600px;
        margin: 0 auto;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .header {
        text-align: center;
        padding: 20px 0;
    }
    .content {
        padding: 20px;
    }
    .button {
        display: block;
        width: 200px;
        margin: 20px auto;
        padding: 15px;
        text-align: center;
        text-decoration: none;
        color: #fff;
        background-color: #007bff;
        border-radius: 5px;
    }
    .footer {
        padding: 20px;
        font-size: 12px;
        color: #777;
    }
    .reset-url {
        max-width: 100%;
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal;
    }
    .copyright {
        text-align: center;
    }
</style>
</html>
