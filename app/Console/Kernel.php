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
        '\App\Console\Commands\PaymentAdvanceReminderCommand',
        '\App\Console\Commands\PaymentFailedCommand',
        '\App\Console\Commands\PaymentWarningCommand',
        '\App\Console\Commands\TaxReminderCommand',
        '\App\Console\Commands\OpenAndCloseCommand',
        '\App\Console\Commands\PriceCommand',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {

        $schedule->command('TaxReminderCommand')
        ->weekly()->mondays()->at('08:30');

        $schedule->command('PaymentWarningCommand')
        ->weekly()->mondays()->thursdays()->at('08:30');

        $schedule->command('PaymentAdvanceReminderCommand')
        ->weekly()->mondays()->at('16:30');

        $schedule->command('PaymentFailedCommand')
        ->everyTenMinutes();

        $schedule->command('InactiveCommand')
        ->everyTenMinutes();

        $schedule->command('OpenAndCloseCommand')
        ->everyMinute();

        $schedule->command('PriceCommand')
        ->everyMinute();

        $schedule->command('ArchiveCommand')
        ->yearly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
