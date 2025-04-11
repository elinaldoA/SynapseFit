<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Agendamento das notificações das refeições
        $schedule->command('notificar:refeicao --tipo=cafe')->dailyAt('08:00');
        $schedule->command('notificar:refeicao --tipo=almoco')->dailyAt('12:40');
        $schedule->command('notificar:refeicao --tipo=lanche')->dailyAt('15:00');
        $schedule->command('notificar:refeicao --tipo=jantar')->dailyAt('20:00');

        // Agendamento das notificações de consumo de água com intervalos razoáveis
        $schedule->command('notificar:consumo-agua')->dailyAt('08:00');
        $schedule->command('notificar:consumo-agua')->dailyAt('10:00');
        $schedule->command('notificar:consumo-agua')->dailyAt('12:00');
        $schedule->command('notificar:consumo-agua')->dailyAt('14:00');
        $schedule->command('notificar:consumo-agua')->dailyAt('16:00');
        $schedule->command('notificar:consumo-agua')->dailyAt('18:00');
        $schedule->command('notificar:consumo-agua')->dailyAt('20:00');
        $schedule->command('notificar:consumo-agua')->dailyAt('22:00');

        // Atualiza Treino e Dieta
        $schedule->command('atualizar:treino-dieta')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
