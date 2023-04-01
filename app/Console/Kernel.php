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
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        //$schedule->command('queue:work --tries=3 --timeout=0')->everyMinute()->withoutOverlapping();
        //$schedule->command('salary-backup')->dailyAt('05:00');
        //$schedule->command('transformPensionType15Plus')->daily()->withoutOverlapping()->runInBackground();
        //run this cmd  create payroll salary increment to generate increment for every year for one time .
        //$schedule->command('payroll:salary-increment')->cron('1 0 1 7 *')->withoutOverlapping()->runInBackground();
//        $schedule->command('payroll:update-monthly')->cron('1 0 * * *')->withoutOverlapping()->runInBackground();
        //$schedule->command('payroll:update-monthly')->everyFiveMinutes()->withoutOverlapping()->runInBackground();
        // Pre PRL alert daily
        //$schedule->command('pre:prl')->dailyAt('12:00');
       // $schedule->command('pre:retirement')->dailyAt('12:30');

//        $schedule->command('payroll:update-monthly')->dailyAt('11:20');;
        //salary increment every year in july at 00:01am
       //$schedule->command('salary-increment:july')->cron('1 0 1 7 *')->withoutOverlapping()->runInBackground();
       //$schedule->command('payroll_arrears_deduction_off:alert')->cron('1 3 2 * *')->withoutOverlapping()->runInBackground();
       // prl and retirement employee check and status change to prl and retirement daily
       //$schedule->command('status:change_to_prl')->dailyAt('2:00');
       //$schedule->command('status:change_to_retirement')->dailyAt('2:15');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
