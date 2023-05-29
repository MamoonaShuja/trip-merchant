<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\SupplierApi\Entities\ApiSupplier;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $objSupplierApis = ApiSupplier::get();
        /** @var ApiSupplier $objSupplierApi */
        foreach ($objSupplierApis as $objSupplierApi) {
            $schedule->command('scrap:data "'.$objSupplierApi->name.'"')->everyMinute();
            $schedule->command('scrap-tour:data "'.$objSupplierApi->name.'"')->everyMinute();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
