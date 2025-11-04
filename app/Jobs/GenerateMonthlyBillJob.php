<?php

namespace App\Jobs;

use App\Models\TrashLocation;
use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateMonthlyBillJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $today = Carbon::now();
        $locations = TrashLocation::all();

        // if ($today->day !== 1) {
        //     $this->info('วันนี้ไม่ใช่วันที่ 1 ของเดือน ไม่สร้างบิล');
        //     return 0;
        // }

        foreach ($locations as $location) {
            if (!$location->user_id) {
                Log::warning("TrashLocation ID {$location->id} has no user_id, skipping bill creation.");
                continue;
            }

            Bill::create([
                'trash_location_id' => $location->id,
                'user_id' => $location->user_id,
                'amount' => 20,
                'status' => 'ยังไม่ชำระ',
                'due_date' => $today->copy()->addDays(7),
            ]);

            Log::info("สร้างบิลสำหรับ TrashLocation ID: {$location->id}");
        }
    }
}
