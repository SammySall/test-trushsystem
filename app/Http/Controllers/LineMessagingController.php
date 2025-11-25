<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class LineMessagingController extends Controller
{
    // ==========================
    // PUSH MESSAGE (ใช้เฉพาะนอก webhook)
    // ==========================
    public function pushMessage($userId, $message)
    {
        $accessToken = env('LINE_CHANNEL_ACCESS_TOKEN');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->post('https://api.line.me/v2/bot/message/push', [
            'to' => $userId,
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $message,
                ]
            ]
        ]);

        return $response->body();
    }

    // ==========================
    // REPLY MESSAGE (ใช้ webhook)
    // ==========================
    private function replyMessage($replyToken, $text, $quickReplies = [])
    {
        $message = [
            'type' => 'text',
            'text' => $text,
        ];

        if (!empty($quickReplies)) {
            $message['quickReply'] = [
                'items' => $quickReplies
            ];
        }

        Http::withHeaders([
            'Authorization' => 'Bearer ' . env('LINE_CHANNEL_ACCESS_TOKEN'),
        ])->post('https://api.line.me/v2/bot/message/reply', [
            'replyToken' => $replyToken,
            'messages' => [$message]
        ]);
    }

    // ==========================
    // WEBHOOK
    // ==========================
    public function webhook(Request $request)
    {
        $events = $request->input('events', []);

        // ตอบกลับ LINE ทันที ป้องกัน timeout / 419
        response()->json(['status' => 'ok'], 200)->send();
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }

        \Log::info('LINE Events: ', $request->input());

        foreach ($events as $event) {

            if (($event['type'] ?? '') !== 'message') {
                continue;
            }

            $replyToken = $event['replyToken'];
            $userId     = $event['source']['userId'];
            $message    = $event['message']['text'];

            // ตรวจสอบสถานะของผู้ใช้ใน cache
            $cacheKey = "line_step_" . $userId;
            $step = cache()->get($cacheKey, 'ask_account_status'); // ขั้นตอนเริ่มต้นเป็น 'ask_account_status'

            // ตรวจสอบว่า user มีบัญชีแล้วหรือยัง
            $user = User::where('line_user_id', $userId)->first();

            // หากผู้ใช้มีบัญชีแล้ว
            if ($user) {
                // ถามว่า "สวัสดีค่ะ, มีอะไรให้ช่วยไหม?"
            $this->replyMessage($replyToken, "คุณมีบัญชีผู้ใช้งานแล้ว 😊\nหากต้องการร้องขอบริการต่างๆ\nกรุณาเข้าไปที่นี่เพื่อดูข้อมูลเพิ่มเติม:\n " . url("/profile"));
                                
                return;  // ไม่ต้องทำอะไรต่อหลังจากนี้
            }

            // หากยังไม่มีบัญชี
            if ($step === 'ask_account_status') {
                cache()->put($cacheKey, 'wait_account_status', 300); // กำหนดเวลาให้ถามอีกครั้งหลัง 5 นาที
                $quickReplies = [
                    [
                        "type" => "action",
                        "action" => [
                            "type" => "message",
                            "label" => "ยังไม่มีบัญชี",
                            "text" => "ยัง"
                        ]
                    ]
                ];

                $this->replyMessage($replyToken, "คุณยังไม่มีบัญชีใช่ไหม? หากยัง กรุณากรอกอีเมลเพื่อสมัครสมาชิก", $quickReplies);
            }

            // ขั้นตอนที่ผู้ใช้ตอบว่า "ยัง"
            switch ($step) {
                case 'wait_account_status':
                    if ($message == 'ยัง') {
                        // ถ้าผู้ใช้ตอบว่า "ยัง" ส่งลิงก์สมัครสมาชิก
                        $this->replyMessage(
                            $replyToken, 
                            "กรุณาสมัครสมาชิกที่นี่: " . url("/register")
                        );
                        break;
                    }
                    break;

                // ขั้นตอนเมื่อผู้ใช้กรอก email
                case 'wait_email':
                    $email = $message;
                    $userCheck = User::where('email', $email)->first();

                    // เก็บจำนวนการพยายามกรอก email
                    $attempts = cache()->get("email_attempts_" . $userId, 0);

                    if (!$userCheck) {
                        $attempts++;
                        cache()->put("email_attempts_" . $userId, $attempts, 300); // เก็บจำนวนการพยายาม

                        if ($attempts >= 3) {
                            $this->replyMessage(
                                $replyToken, 
                                "กรุณากรอกอีเมลใหม่หรือลงทะเบียนที่นี่: " . url("/register")
                            );
                            cache()->forget("email_attempts_" . $userId); // ล้างการพยายามเมื่อเกิน 3 ครั้ง
                        } else {
                            $this->replyMessage(
                                $replyToken, 
                                "ไม่พบ Email นี้ในระบบค่ะ 🙁\nคุณมีอีก " . (3 - $attempts) . " ครั้งในการกรอก Email"
                            );
                        }
                        break;
                    }

                    // ถ้าเจอ Email ในระบบ, ให้ข้ามไปถามชื่อ-นามสกุล
                    cache()->put("line_email_" . $userId, $email, 300);
                    cache()->put($cacheKey, 'wait_name', 300);

                    $this->replyMessage($replyToken, "กรุณาพิมพ์ ชื่อ - นามสกุล");
                    break;

                // ขั้นตอนสุดท้ายเมื่อกรอกชื่อ-นามสกุล
                case 'wait_name':
                    $email = cache()->get("line_email_" . $userId);
                    $userModel = User::where('email', $email)->first();

                    if ($userModel) {
                        $userModel->line_user_id = $userId;
                        $userModel->name = $message;
                        $userModel->save();

                        // ล้างค่าใน cache
                        cache()->forget($cacheKey);
                        cache()->forget("line_email_" . $userId);
                        cache()->forget("email_attempts_" . $userId); // ล้างการพยายามกรอก email

                        $this->replyMessage($replyToken, "ลงทะเบียนสำเร็จแล้ว 😊");
                    }
                    break;
            }
        }

        return;
    }

}
