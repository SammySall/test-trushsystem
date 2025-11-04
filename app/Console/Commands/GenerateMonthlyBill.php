<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\TrashLocation;
use App\Models\Bill;
use Carbon\Carbon;

class GenerateMonthlyBill extends Command
{
    protected $signature = 'bill:generate-monthly';
    protected $description = 'สร้างบิลอัตโนมัติในวันแรกของแต่ละเดือน';

    public function handle()
    {
        $today = Carbon::now();

        // if ($today->day !== 1) {
        //     $this->info('วันนี้ไม่ใช่วันที่ 1 ของเดือน ไม่สร้างบิล');
        //     return 0;
        // }

        $locations = TrashLocation::all();

        foreach ($locations as $location) {
            if (!$location->user_id) {
                Log::warning("TrashLocation ID {$location->id} has no user_id, skipping bill creation.");
                continue;
            }
            
            Bill::create([
                'trash_location_id' => $location->id,
                'user_id' => $location->user_id,
                'amount' => 20, // ใส่ค่าเริ่มต้นตามต้องการ
                'status' => 'ยังไม่ชำระ',
                'due_date' => $today->copy()->addDays(7),
            ]);

            $this->info("สร้างบิลสำหรับ TrashLocation ID: {$location->id}");
        }

        $this->info('สร้างบิลเรียบร้อยสำหรับทุก TrashLocation');
        return 0;
    }
}
