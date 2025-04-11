<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SynapseFit</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        /* Efeitos de hover e animações */
        .card:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        .card-button:hover {
            background-color: #1d4ed8;
        }

        .social-icon:hover {
            color: #1d4ed8;
        }

        /* Adicionando background de academia */
        body {
            background-image: url('https://canalperguntas.com/wp-content/uploads/2021/04/fitness-men-woman-bodybuilders-1280x640.jpg');
            /* Substitua pela URL da imagem desejada */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }
    </style>
</head>

<body>

    <!-- Seção de Introdução -->
    <div class="min-h-screen flex items-center justify-center" data-aos="fade-up" data-aos-duration="1500">
        <div class="text-center max-w-2xl">
            <h1 class="text-5xl font-extrabold text-blue-500">SynapseFit</h1>
            <h3 class="text-2xl mt-4">Conexão entre cérebro e músculo para um treino mais eficiente.</h3>

            <p class="mt-6 text-lg text-gray-300">
                O SynapseFit vai além de um simples treino. Analisamos seu IMC, ajustamos os treinos, geramos dietas
                personalizadas e calculamos a queima de calorias, tudo adaptado ao seu progresso e objetivos.
                Alcance seus resultados com tecnologia e inteligência.
            </p>

            <div class="mt-8 space-x-4">
                <a href="{{ route('register') }}"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg transition duration-300">
                    Cadastre-se Agora
                </a>
                <a href="{{ route('login') }}"
                    class="px-6 py-3 border border-gray-500 text-gray-300 hover:bg-gray-700 rounded-lg transition duration-300">
                    Já tenho uma conta
                </a>
            </div>
        </div>
    </div>

    <!-- Seção de Como Funciona -->
    <div class="bg-gray-800 py-16" data-aos="fade-up" data-aos-duration="1500">
        <div class="text-center">
            <h2 class="text-4xl font-bold text-white">Como Funciona o SynapseFit?</h2>
            <p class="mt-4 text-lg text-gray-300">Com o SynapseFit, você tem uma abordagem personalizada para treinos e
                dieta, com base no seu IMC, progresso e objetivos. Confira como nosso sistema funciona:</p>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Como Funciona - Passo 1 -->
            <div class="text-center bg-gray-700 p-6 rounded-lg shadow-lg" data-aos="zoom-in" data-aos-duration="1000">
                <h3 class="text-2xl font-semibold text-blue-500">1. Avaliação do IMC</h3>
                <p class="mt-4 text-lg text-gray-300">Nosso sistema analisa seu IMC (Índice de Massa Corporal) para
                    entender seu ponto de partida e adaptar seus treinos e dieta de forma precisa.</p>
            </div>

            <!-- Como Funciona - Passo 2 -->
            <div class="text-center bg-gray-700 p-6 rounded-lg shadow-lg" data-aos="zoom-in" data-aos-duration="1000">
                <h3 class="text-2xl font-semibold text-blue-500">2. Treino Personalizado</h3>
                <p class="mt-4 text-lg text-gray-300">Com base no seu IMC e objetivos, o SynapseFit gera treinos
                    automatizados, otimizados para o seu progresso e nível de resistência.</p>
            </div>

            <!-- Como Funciona - Passo 3 -->
            <div class="text-center bg-gray-700 p-6 rounded-lg shadow-lg" data-aos="zoom-in" data-aos-duration="1000">
                <h3 class="text-2xl font-semibold text-blue-500">3. Dieta Personalizada</h3>
                <p class="mt-4 text-lg text-gray-300">O sistema gera uma dieta personalizada para você, considerando
                    seus objetivos (hipertrofia, emagrecimento, resistência) e calculando a ingestão calórica
                    necessária.</p>
            </div>
        </div>
    </div>

    <!-- Seção de Planos -->
    <div class="bg-gray-800 py-16" data-aos="fade-up" data-aos-duration="1500">
        <div class="text-center">
            <h2 class="text-4xl font-bold text-white">Escolha o Seu Plano</h2>
            <p class="mt-4 text-lg text-gray-300">Cada plano é projetado para se adequar às suas necessidades e
                objetivos. Escolha o melhor para você!</p>
        </div>

        <div class="mt-12 flex justify-center gap-8">
            <!-- Plano Grátis -->
            <div class="card bg-gray-700 p-6 rounded-lg shadow-lg w-80" data-aos="zoom-in" data-aos-duration="1000">
                <h3 class="text-2xl font-semibold text-blue-500">Plano Grátis</h3>
                <p class="mt-4 text-lg text-gray-300">Experimente SynapseFit por 7 dias e tenha acesso ao treino básico.
                    Acompanhe seu progresso por 7 dias.</p>
                <div class="mt-6 text-2xl text-white">Grátis</div>
                <ul class="mt-4 text-gray-300">
                    <li>Treino básico de 7 dias</li>
                    <li>Acompanhamento inicial (sem personalização)</li>
                    <li>Sem ajustes automáticos de treino ou dieta</li>
                    <li>Sem cálculos de queima de calorias</li>
                    <li>Sem suporte 24/7</li>
                    <li>Acesso a 10 treinos cadastrados</li> <!-- Limite de treinos -->
                </ul>
                <a href="{{ route('register') }}"
                    class="mt-6 block text-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg card-button">Experimente
                    Grátis</a>
            </div>

            <!-- Plano Básico -->
            <div class="card bg-gray-700 p-6 rounded-lg shadow-lg w-80" data-aos="zoom-in" data-aos-duration="1000">
                <h3 class="text-2xl font-semibold text-blue-500">Plano Básico</h3>
                <p class="mt-4 text-lg text-gray-300">Ideal para iniciantes, com treinos eficientes, queima de calorias
                    e acesso a mais de 1000 treinos cadastrados, ajustados conforme o seu progresso.</p>
                <div class="mt-6 text-2xl text-white">R$ 49,99/mês</div>
                <ul class="mt-4 text-gray-300">
                    <li>Treino personalizado básico ajustado automaticamente</li>
                    <li>Acompanhamento semanal</li>
                    <li>Acesso a 200 treinos cadastrados</li> <!-- Limite de treinos -->
                    <li>Cálculos de queima de calorias durante os treinos</li>
                    <li>Sem suporte 24/7</li>
                </ul>
                <a href="{{ route('register') }}"
                    class="mt-6 block text-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg card-button">Assine
                    Agora</a>
            </div>

            <!-- Plano Profissional -->
            <div class="card bg-gray-700 p-6 rounded-lg shadow-lg w-80" data-aos="zoom-in" data-aos-duration="1000">
                <h3 class="text-2xl font-semibold text-blue-500">Plano Profissional</h3>
                <p class="mt-4 text-lg text-gray-300">Para quem já tem experiência e deseja otimizar seus treinos,
                    dietas e queima de calorias automaticamente conforme o seu progresso.</p>
                <div class="mt-6 text-2xl text-white">R$ 99,99/mês</div>
                <ul class="mt-4 text-gray-300">
                    <li>Treino altamente personalizado ajustado automaticamente</li>
                    <li>Acompanhamento diário</li>
                    <li>Acesso a 500 treinos cadastrados</li> <!-- Limite de treinos -->
                    <li>Ajuste automático de dieta com base no progresso</li>
                    <li>Cálculos de queima de calorias diários</li>
                    <li>Suporte 24/7</li>
                </ul>
                <a href="{{ route('register') }}"
                    class="mt-6 block text-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg card-button">Assine
                    Agora</a>
            </div>

            <!-- Plano Premium -->
            <div class="card bg-gray-700 p-6 rounded-lg shadow-lg w-80" data-aos="zoom-in" data-aos-duration="1000">
                <h3 class="text-2xl font-semibold text-blue-500">Plano Premium</h3>
                <p class="mt-4 text-lg text-gray-300">A opção definitiva com suporte completo, ajustes de treinos e
                    dieta automáticos baseados no seu progresso contínuo, e cálculo de queima de calorias otimizado.</p>
                <div class="mt-6 text-2xl text-white">R$ 149,99/mês</div>
                <ul class="mt-4 text-gray-300">
                    <li>Treino altamente personalizado ajustado automaticamente</li>
                    <li>Acompanhamento 24/7</li>
                    <li>Acesso a 1000 treinos cadastrados</li> <!-- Acesso total -->
                    <li>Consultoria nutricional</li>
                    <li>Ajuste automático da dieta com base no progresso contínuo</li>
                    <li>Cálculos avançados de queima de calorias</li>
                    <li>Suporte prioritário 24/7</li>
                </ul>
                <a href="{{ route('register') }}"
                    class="mt-6 block text-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg card-button">Assine
                    Agora</a>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="bg-gray-800 py-8">
        <div class="text-center text-white">
            <p>&copy; 2025 SynapseFit. Todos os direitos reservados.</p>
            <div class="mt-4">
                <a href="#" class="social-icon mx-3 text-2xl text-gray-400 hover:text-blue-500"><i
                        class="fab fa-facebook"></i></a>
                <a href="#" class="social-icon mx-3 text-2xl text-gray-400 hover:text-blue-500"><i
                        class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon mx-3 text-2xl text-gray-400 hover:text-blue-500"><i
                        class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon mx-3 text-2xl text-gray-400 hover:text-blue-500"><i
                        class="fab fa-youtube"></i></a>
            </div>
            <div class="mt-4">
                <p class="text-sm text-gray-400">Política de Privacidade | Termos de Uso</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
