<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SynapseFit | Conecte Corpo e Mente</title>
    <meta name="description"
        content="Treinos e nutrição inteligentes com base no seu corpo. Acesse planos, dietas e treinos personalizados com SynapseFit." />
    <meta name="theme-color" content="#0f172a" />
    <meta property="og:title" content="SynapseFit - Inteligência a favor do seu corpo" />
    <meta property="og:description" content="Transforme seu estilo de vida com treinos e alimentação personalizados." />
    <meta property="og:image" content="https://source.unsplash.com/featured/?fitness,health" />
    <meta property="og:url" content="https://synapsefit.com" />
    <meta property="og:type" content="website" />
    <link rel="icon" href="/favicon.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #0f64d3;
            color: #f1f5f9;
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .card {
            background-color: #1e293b;
            border-radius: 1rem;
            padding: 2rem;
            transition: 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>

<body>
    <header>
        <section class="min-h-screen flex items-center justify-center backdrop px-6 py-16" data-aos="fade-up"
            data-aos-duration="1500">
            <div class="text-center max-w-2xl">
                <img src="{{ asset('img/logo.png') }}" alt="Logo SynapseFit"
                    class="mx-auto w-32 md:w-40 mb-6 drop-shadow-lg">
                <!--<h1 class="text-5xl md:text-6xl font-extrabold text-blue-500 drop-shadow-lg">SynapseFit</h1>-->
                <h2 class="text-xl md:text-2xl mt-4 font-light">Cérebro e músculo conectados, resultados elevados.</h2>
                <p class="mt-6 text-gray-300 text-lg leading-relaxed">Alcance seus objetivos com tecnologia e
                    inteligência. O SynapseFit analisa seu IMC, ajusta treinos, gera dietas personalizadas e calcula sua
                    queima calórica automaticamente.</p>
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow transition duration-300">Comece
                        Agora</a>
                    <a href="{{ route('login') }}"
                        class="px-8 py-3 border border-white text-white hover:bg-white hover:text-gray-900 font-semibold rounded-lg transition duration-300">Já
                        sou membro</a>
                </div>
            </div>
        </section>
    </header>


    <main>
        <section id="funciona" class="py-20 px-6" data-aos="fade-up">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold">Como Funciona?</h2>
                <p class="text-gray-400 mt-4">Em três passos simples, o SynapseFit transforma seu estilo de vida.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-7xl mx-auto">
                <div class="card" data-aos="fade-right">
                    <h3 class="text-2xl font-bold text-blue-400 mb-2">1. IMC e Perfil</h3>
                    <p class="text-gray-300">Começamos entendendo seu corpo. Você informa seus dados e objetivos.</p>
                </div>
                <div class="card" data-aos="fade-up">
                    <h3 class="text-2xl font-bold text-blue-400 mb-2">2. Treino Inteligente</h3>
                    <p class="text-gray-300">Nosso sistema monta um plano de treino ajustado ao seu nível atual.</p>
                </div>
                <div class="card" data-aos="fade-left">
                    <h3 class="text-2xl font-bold text-blue-400 mb-2">3. Dieta Dinâmica</h3>
                    <p class="text-gray-300">Criamos um plano alimentar que evolui com você e com seus resultados.</p>
                </div>
            </div>
        </section>

        <section class="bg-slate-950 py-20 px-6" id="treinos" data-aos="fade-up">
            <div class="text-center text-white mb-12">
                <h2 class="text-4xl font-bold text-blue-400">+500 Treinos Inteligentes</h2>
                <p class="text-gray-300 mt-4 text-lg">Seu treino nunca mais será o mesmo. Evolua constantemente com treinos que se adaptam a você.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-7xl mx-auto">
                <div class="card" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-5xl text-blue-500 mb-4">💪</div>
                    <h3 class="text-2xl font-semibold mb-2">Alta Variedade</h3>
                    <p class="text-gray-300">Treinos para hipertrofia, emagrecimento, resistência, mobilidade e muito mais. Você escolhe seu foco.</p>
                </div>
                <div class="card" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-5xl text-blue-500 mb-4">🔁</div>
                    <h3 class="text-2xl font-semibold mb-2">Atualizações Automáticas</h3>
                    <p class="text-gray-300">À medida que você evolui, seus treinos evoluem com você. Nada de rotina estagnada ou exercícios repetidos.</p>
                </div>
                <div class="card" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-5xl text-blue-500 mb-4">📈</div>
                    <h3 class="text-2xl font-semibold mb-2">Progresso Acompanhado</h3>
                    <p class="text-gray-300">O sistema registra sua performance e ajusta cargas, repetições e séries para resultados reais e consistentes.</p>
                </div>
            </div>
        </section>


        <section class="bg-slate-900 py-20" id="planos" data-aos="fade-up">
            <div class="text-center text-white mb-12">
                <h2 class="text-4xl font-bold">Plano de Acesso</h2>
                <p class="text-gray-400 mt-4">Teste gratuito por 7 dias com todos os recursos desbloqueados.</p>
            </div>
            <div class="flex justify-center">
                <div class="card max-w-md text-center">
                    <span class="text-sm text-red-500 font-bold uppercase">Oferta por tempo limitado</span>
                    <h3 class="text-3xl font-bold my-4">Plano Grátis</h3>
                    <p class="text-lg text-gray-300 mb-4">Aproveite todos os benefícios por uma semana sem custo!</p>
                    <div class="text-5xl font-bold text-blue-400 mb-6">R$ 0,00</div>
                    <div id="countdown" class="text-xl text-red-400 mb-4">00:07</div>
                    <a href="{{ route('register') }}"
                        class="btn bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">Começar Teste</a>
                </div>
            </div>
        </section>

        <section class="py-20" id="depoimentos" data-aos="fade-up">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold">Depoimentos</h2>
                <p class="text-gray-400">Veja o que nossos usuários têm a dizer</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-7xl mx-auto">
                <div class="card">
                    <p class="text-xl text-blue-400 font-semibold">"Em 3 meses ganhei energia, foco e definição
                        muscular."</p>
                    <p class="mt-4 text-gray-300">– Larissa Souza</p>
                </div>
                <div class="card">
                    <p class="text-xl text-blue-400 font-semibold">"Nunca fui tão bem orientado no treino e na
                        alimentação."</p>
                    <p class="mt-4 text-gray-300">– André Costa</p>
                </div>
                <div class="card">
                    <p class="text-xl text-blue-400 font-semibold">"Vale cada segundo. A IA me entende melhor do que eu
                        mesmo."</p>
                    <p class="mt-4 text-gray-300">– Rafael Lima</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-slate-800 py-8 text-center text-gray-400 text-sm">
        <p>&copy; 2025 SynapseFit. Todos os direitos reservados.</p>
        <p class="mt-2">
            <a href="/sobre-nos" class="hover:text-blue-500">Sobre Nós</a> |
            <a href="/politica-privacidade" class="hover:text-blue-500">Política de Privacidade</a>
        </p>
    </footer>

    <script>
        AOS.init();

        const countdown = document.getElementById('countdown');
        let end = new Date().getTime() + 7 * 60 * 60 * 1000;
        setInterval(() => {
            let now = new Date().getTime();
            let distance = end - now;
            if (distance < 0) {
                countdown.innerText = "Oferta Expirada!";
                return;
            }
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            countdown.innerText = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
        }, 1000);
    </script>
</body>

</html>
