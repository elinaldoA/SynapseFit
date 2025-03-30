# SynapseFit

Sistema de Gestão de Treinos e Dieta

Este sistema é uma aplicação web construída com Laravel para academias, permitindo a criação e gestão de treinos automáticos, acompanhamento de progresso, e geração dinâmica de dietas para os alunos, baseadas no seu IMC e objetivos. O sistema conta com funcionalidades de treino, controle de séries, progressão de carga e até mesmo uma dieta personalizada com foco em hipertrofia, emagrecimento ou resistência.

Funcionalidades

Treinamento

Geração automática de treinos: O sistema monta treinos de acordo com o IMC e objetivo do aluno (hipertrofia, emagrecimento ou resistência).

Acompanhamento de séries: O treino é dividido em fichas (A, B, C), e a progressão é feita de forma sequencial. Quando o aluno completa uma ficha, a próxima é liberada.

Progresso das séries: O sistema mantém o progresso das séries realizadas e salva as informações sobre carga, repetições e tempo de descanso.

Botões interativos para o treino: O aluno pode iniciar e finalizar séries e treinos, com a possibilidade de controlar o tempo de descanso através de um cronômetro visual.

Botões de ação para cada exercício: Para cada exercício, há botões de "Iniciar Série" e "Finalizar Série", que são habilitados e desabilitados conforme o progresso das séries.


Dieta

Geração automática de dieta: Com base no IMC e no objetivo do aluno, uma dieta personalizada é criada, incluindo alimentação, suplementação e ingestão de água.

Dietas dinâmicas: As dietas são atualizadas com base nos avanços e mudanças no IMC do aluno, permitindo uma adaptação constante.


Interface

Painel Admin: Utilizando o template Laravel SB Admin 2, o painel é clean e de fácil navegação, com um design high-tech, ideal para gestão de treinos e monitoramento de progresso.

Modal de Descanso: Para cada exercício, é exibido um modal com um timer visual, permitindo que o aluno gerencie seu descanso de maneira eficiente.

Modal de Confirmação e Parabéns: Ao finalizar um treino, o aluno recebe um modal de confirmação, e, ao completar todo o treino, um modal de parabéns é exibido com o total de carga levantada.


Tecnologias Utilizadas

Laravel: Framework PHP utilizado para construir a aplicação back-end.

Bootstrap: Framework CSS utilizado para o design e responsividade.

JavaScript: Utilizado para funcionalidades interativas no front-end (ex: cronômetro de descanso e manipulação de botões).

MySQL: Banco de dados utilizado para armazenar informações de alunos, treinos e progresso.


Requisitos

Para rodar o sistema em sua máquina, você precisa dos seguintes requisitos:

PHP 8.0+

Laravel 8+

Composer

MySQL


Instalação

1. Clone o repositório:

git clone https://github.com/usuario/repo.git
cd repo


2. Instale as dependências:

composer install


3. Configure o ambiente:

Copie o arquivo .env.example para .env e configure suas credenciais do banco de dados.

cp .env.example .env

Em seguida, configure o arquivo .env com as informações do seu banco de dados.


4. Gere a chave do aplicativo:

php artisan key:generate


5. Execute as migrações do banco de dados:

php artisan migrate


6. Execute o servidor:

php artisan serve



Agora, você pode acessar o sistema via http://localhost:8000.

Como Utilizar

Para Administradores:

Criar treinos: O administrador pode criar treinos personalizados para os alunos, com base nos seus objetivos e IMC.

Monitorar progresso: O administrador pode visualizar o progresso de cada aluno, incluindo o histórico de cargas levantadas e a conclusão de séries.


Para Alunos:

Iniciar treino: O aluno pode iniciar o treino com um simples clique e acompanhar o progresso das séries.

Controlar carga: Durante o treino, o aluno pode ajustar a carga (peso) e as repetições para cada exercício.

Ver dieta: O aluno pode acessar sua dieta personalizada e ajustada de acordo com seu objetivo.

Receber feedback: Ao concluir o treino, o aluno recebe um feedback de parabéns com o total de carga levantada.


Estrutura do Projeto

app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   ├── Requests/
│   └── Kernel.php
├── Models/
│   ├── Workout.php
│   ├── Progress.php
│   └── Diet.php
└── Views/
    ├── layouts/
    ├── workouts/
    ├── diets/
    └── dashboard.blade.php
config/
└── app.php
database/
├── migrations/
└── seeders/
public/
├── assets/
│   ├── js/
│   └── css/
resources/
└── views/
    ├── workouts/
    ├── diets/
    └── admin/
routes/
└── web.php

Contribuição

1. Faça um fork do repositório.


2. Crie uma branch para sua feature (git checkout -b feature/nova-feature).


3. Faça suas alterações e commit (git commit -am 'Adiciona nova feature').


4. Envie para o repositório (git push origin feature/nova-feature).


5. Abra um Pull Request.



Licença

Este projeto está licenciado sob a MIT License.


---
