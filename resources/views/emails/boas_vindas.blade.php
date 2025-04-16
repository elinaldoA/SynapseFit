<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo ao SynapseFit</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 30px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 40px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .titulo {
            color: #00bfa6;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .mensagem {
            font-size: 16px;
            line-height: 1.6;
        }
        .assinatura {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #00bfa6;
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }
        .logo {
            width: 150px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('img/logo.png') }}" alt="SynapseFit" class="logo">

        <div class="titulo">Bem-vindo ao SynapseFit!</div>

        <div class="mensagem">
            Olá {{ $user->name }},<br><br>

            É um prazer ter você com a gente! 🎉<br><br>

            A partir de agora, você faz parte de um sistema inteligente que vai te ajudar a alcançar seus objetivos com mais foco, organização e performance. Treinos personalizados, dieta ajustada ao seu corpo, lembretes inteligentes e suporte especializado – tudo em um só lugar.<br><br>

            Estamos aqui para te acompanhar em cada passo da sua jornada. 💪<br>

            Acesse seu painel e comece hoje mesmo a evoluir com o SynapseFit!

            <br><br>
            <a href="{{ url('/login') }}" class="btn">Acessar Agora</a>
        </div>

        <div class="assinatura">
            Equipe SynapseFit<br>
            Transformando dados em resultados.
        </div>
    </div>
</body>
</html>
