<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\GenerateMonthlyBillJob;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // สำหรับทดสอบ: รันทุกนาที
        // $schedule->call(function () {
        //     GenerateMonthlyBillJob::dispatch();
        // })->everyMinute();

        // สำหรับใช้งานจริง: รันเดือนละครั้ง วันที่ 1 เวลา 00:01
        $schedule->call(function () {
            GenerateMonthlyBillJob::dispatch();
        })->monthlyOn(1, '00:01');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
