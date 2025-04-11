<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SynapseFit | Treino e Nutrição Inteligente</title>

    <!-- SEO & Meta -->
    <meta name="description"
        content="Conecte corpo e mente com SynapseFit. Avaliação de IMC, treinos, dietas e tecnologia inteligente para transformar seu estilo de vida.">
    <meta name="author" content="SynapseFit">
    <meta name="theme-color" content="#1e40af">
    <meta name="keywords" content="treino, nutrição, emagrecimento, hipertrofia, saúde, fitness, alimentação, dieta, plano de treino, tecnologia, academia">

    <!-- Open Graph -->
    <meta property="og:title" content="SynapseFit - Cérebro e músculo conectados">
    <meta property="og:description" content="Treinos e dietas personalizadas com inteligência e tecnologia.">
    <meta property="og:image"
        content="https://canalperguntas.com/wp-content/uploads/2021/04/fitness-men-woman-bodybuilders-1280x640.jpg">
    <meta property="og:url" content="https://synapsefit.com">
    <meta property="og:type" content="website">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon.png">

    <!-- AOS Animations -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            background: url('https://canalperguntas.com/wp-content/uploads/2021/04/fitness-men-woman-bodybuilders-1280x640.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .card:hover {
            transform: translateY(-5px) scale(1.05);
            transition: 0.3s ease-in-out;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
        }

        .card-button:hover {
            background-color: #2563eb;
        }

        .social-icon:hover {
            color: #3b82f6;
        }

        .backdrop {
            background-color: rgba(0, 0, 0, 0.75);
        }

        #scrollToTop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 50;
            display: none;
        }

        #scrollToTop.show {
            display: block;
        }

        .testimonial {
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            padding: 30px;
        }

        .graph-card {
            background: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            padding: 30px;
        }
    </style>
</head>

<body class="font-sans">

    <!-- Introdução -->
    <header>
        <section class="min-h-screen flex items-center justify-center backdrop px-6 py-16" data-aos="fade-up"
            data-aos-duration="1500">
            <div class="text-center max-w-2xl">
                <h1 class="text-5xl md:text-6xl font-extrabold text-blue-500 drop-shadow-lg">SynapseFit</h1>
                <h2 class="text-xl md:text-2xl mt-4 font-light">Cérebro e músculo conectados, resultados elevados.</h2>

                <p class="mt-6 text-gray-300 text-lg leading-relaxed">
                    Alcance seus objetivos com tecnologia e inteligência. O SynapseFit analisa seu IMC, ajusta treinos,
                    gera dietas personalizadas e calcula sua queima calórica automaticamente.
                </p>

                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow transition duration-300">
                        Comece Agora
                    </a>
                    <a href="{{ route('login') }}"
                        class="px-8 py-3 border border-white text-white hover:bg-white hover:text-gray-900 font-semibold rounded-lg transition duration-300">
                        Já sou membro
                    </a>
                </div>
            </div>
        </section>
    </header>

    <!-- Como Funciona -->
    <main>
        <section class="bg-gray-900 bg-opacity-90 py-20 px-4" id="como-funciona" data-aos="fade-up"
            data-aos-duration="1500">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-white mb-4">Como Funciona o SynapseFit?</h2>
                <p class="text-lg text-gray-300">Uma jornada personalizada baseada no seu corpo e mente.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <div class="text-center bg-gray-800 p-6 rounded-lg shadow-lg" data-aos="zoom-in">
                    <h3 class="text-2xl font-semibold text-blue-400">1. Avaliação do IMC</h3>
                    <p class="mt-4 text-gray-300">Entendemos seu ponto de partida com precisão, adaptando treino e
                        dieta.</p>
                </div>
                <div class="text-center bg-gray-800 p-6 rounded-lg shadow-lg" data-aos="zoom-in">
                    <h3 class="text-2xl font-semibold text-blue-400">2. Treino Inteligente</h3>
                    <p class="mt-4 text-gray-300">Programas otimizados automaticamente para seu nível e objetivo.</p>
                </div>
                <div class="text-center bg-gray-800 p-6 rounded-lg shadow-lg" data-aos="zoom-in">
                    <h3 class="text-2xl font-semibold text-blue-400">3. Dieta Dinâmica</h3>
                    <p class="mt-4 text-gray-300">Alimentação personalizada com foco em performance e saúde.</p>
                </div>
            </div>
        </section>

        <!-- Planos -->
        <section id="pricing" class="bg-gray-800 py-12">
            <div class="flex justify-center items-center">
                <div class="container text-center text-white">
                    <h2 class="text-3xl font-semibold mb-6">Planos de Assinatura</h2>
                    <p class="text-lg text-gray-300 mb-8">Aproveite nosso plano gratuito com acesso total por 7 dias! Só por tempo limitado.</p>

                    <div class="flex justify-center gap-6">
                        <!-- Plano Grátis -->
                        <div class="bg-gray-900 p-6 rounded-lg shadow-lg relative">
                            <span class="absolute top-0 right-0 bg-red-600 text-white text-sm font-bold py-1 px-3 rounded-l-lg">
                                Oferta Limitada
                            </span>
                            <h3 class="text-2xl font-bold mb-4">Plano Grátis</h3>
                            <p class="text-lg mb-4">Acesso completo por 7 dias. Experimente todos os recursos!</p>
                            <div class="text-4xl font-bold mb-6">R$ 0,00</div>

                            <!-- Contagem Regressiva -->
                            <p class="text-sm text-red-400 mb-4">Oferta termina em:</p>
                            <div id="countdown" class="text-2xl font-semibold text-red-600">
                                <span>00:</span><span>07:</span><span>00</span> (horas:minutos)
                            </div>

                            <a href="#" class="block bg-blue-600 text-white py-3 mt-6 rounded-lg hover:bg-blue-700 transition duration-300">Assine agora</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            // Função de contagem regressiva
            let countdownDate = new Date(new Date().getTime() + 7 * 24 * 60 * 60 * 1000); // 7 dias a partir de agora
            let countdown = document.getElementById('countdown');

            let x = setInterval(function() {
                let now = new Date().getTime();
                let distance = countdownDate - now;

                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                countdown.innerHTML = `<span>${hours < 10 ? "0" + hours : hours}:</span><span>${minutes < 10 ? "0" + minutes : minutes}</span>`;

                if (distance < 0) {
                    clearInterval(x);
                    countdown.innerHTML = "Oferta Expirada!";
                }
            }, 1000);
        </script>


        <!-- Testemunhos -->
        <section class="bg-gray-800 py-20 px-4" id="testemunhos" data-aos="fade-up" data-aos-duration="1500">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-white mb-4">O que nossos usuários estão dizendo</h2>
            </div>
            <div class="flex flex-wrap justify-center gap-8">
                <div class="testimonial max-w-lg mx-auto" data-aos="fade-right">
                    <p class="text-lg text-gray-300">"O SynapseFit mudou minha vida! Com a ajuda dos treinos inteligentes e
                        a dieta personalizada, consegui alcançar meus objetivos muito mais rápido."</p>
                    <div class="mt-4 flex justify-center items-center">
                        <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Foto do usuário" class="w-12
                            h-12 rounded-full">
                        <p class="ml-4 text-white font-semibold">Lucas Almeida</p>
                    </div>
                </div>
                <div class="testimonial max-w-lg mx-auto" data-aos="fade-left">
                    <p class="text-lg text-gray-300">"Acompanhar meu progresso nunca foi tão fácil. A plataforma me dá
                        todas as ferramentas que eu preciso para crescer e melhorar!"</p>
                    <div class="mt-4 flex justify-center items-center">
                        <img src="https://randomuser.me/api/portraits/women/5.jpg" alt="Foto do usuário" class="w-12
                            h-12 rounded-full">
                        <p class="ml-4 text-white font-semibold">Maria Souza</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Rodapé -->
    <footer class="bg-gray-900 py-10 px-4 text-center text-white">
        <div>
            <div class="flex justify-center gap-6 mb-4">
                <a href="https://facebook.com" target="_blank" class="social-icon text-2xl">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://twitter.com" target="_blank" class="social-icon text-2xl">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://instagram.com" target="_blank" class="social-icon text-2xl">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>

            <div class="text-gray-300">
                <p>&copy; 2025 SynapseFit. Todos os direitos reservados.</p>
                <p>Termos de Serviço | Política de Privacidade</p>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scrollToTop" class="bg-blue-600 text-white p-3 rounded-full shadow-lg">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // Scroll to top button
        const scrollToTopBtn = document.getElementById('scrollToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
        });

        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // AOS Initialization
        AOS.init();
    </script>

</body>

</html>
