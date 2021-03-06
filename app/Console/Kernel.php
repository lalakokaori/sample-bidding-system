<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\Defect::class,
        \App\Console\Commands\LogDemo::class,
        \App\Console\Commands\ItemWonOneWeekReturn::class,
        \App\Console\Commands\CancelCheckoutRequest::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('inspire')
        //         ->hourly();

        //$schedule->command('defect')
         //        ->everyMinute();

        //$schedule->command('log:demo')
        //         ->everyMinute();
        $schedule->command('oneWeekForfeit')
                 ->everyMinute();
                 
        $schedule->command('checkoutForfeit')
                 ->everyMinute();
        
    }
}
