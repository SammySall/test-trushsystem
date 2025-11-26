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

        // ตอบกลับ LINE ทันที ป้องกัน timeout
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
            $message    = trim($event['message']['text']);

            // ตรวจสอบสถานะของผู้ใช้
            $cacheKey = "line_step_" . $userId;
            $step = cache()->get($cacheKey, 'ask_account_status');

            $user = User::where('line_user_id', $userId)->first();

            // หากมีบัญชีแล้ว
            if ($user) {
                $this->replyMessage($replyToken, 
                    "คุณมีบัญชีผู้ใช้งานแล้ว 😊\nสามารถดูข้อมูลเพิ่มเติมได้ที่นี่:\n" . url("/profile")
                );
                return;
            }

            // 🔵 ขั้นตอนแรก — ถามก่อนว่ามีบัญชีหรือยัง
            if ($step === 'ask_account_status') {

                cache()->put($cacheKey, 'wait_account_status', 300);

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

                $this->replyMessage(
                    $replyToken, 
                    "คุณยังไม่มีบัญชีใช่ไหมคะ?\nหากยัง กรุณาเลือก “ยัง” เพื่อสมัครสมาชิก",
                    $quickReplies
                );

                return;
            }

            // 🟦 ขั้นตอนตอบว่า “ยัง”
            if ($step === 'wait_account_status') {

                if ($message === "ยัง") {

                    // เปลี่ยนไปขั้นตอนกรอกอีเมล
                    cache()->put($cacheKey, 'wait_email', 300);

                    $this->replyMessage(
                        $replyToken,
                        "กรุณากรอกอีเมลที่ต้องการใช้สมัครสมาชิกค่ะ 😊"
                    );

                    return;
                }

                // หากตอบอย่างอื่น
                $this->replyMessage($replyToken, "หากคุณยังไม่มีบัญชี กรุณาพิมพ์ “ยัง” ค่ะ");
                return;
            }

            // 🟩 ขั้นตอนกรอกอีเมล
            if ($step === 'wait_email') {

                $email = $message;

                $userCheck = User::where('email', $email)->first();
                $attemptKey = "email_attempts_" . $userId;
                $attempts = cache()->get($attemptKey, 0);

                if (!$userCheck) {
                    $attempts++;
                    cache()->put($attemptKey, $attempts, 300);

                    if ($attempts >= 3) {

                        $this->replyMessage(
                            $replyToken,
                            "ไม่พบอีเมลนี้ในระบบ\nกรุณาลงทะเบียนที่ลิงก์นี้ค่ะ:\n" . url("/register")
                        );

                        cache()->forget($attemptKey);
                        cache()->forget($cacheKey);
                        return;
                    }

                    $this->replyMessage(
                        $replyToken,
                        "ไม่พบอีเมลนี้ในระบบค่ะ 🙁\nคุณมีโอกาสอีก " . (3 - $attempts) . " ครั้ง"
                    );

                    return;
                }

                // เจออีเมล → ไปขั้นตอนกรอกชื่อ
                cache()->put("line_email_" . $userId, $email, 300);
                cache()->put($cacheKey, 'wait_name', 300);

                $this->replyMessage($replyToken, "กรุณาพิมพ์ ชื่อ - นามสกุล ค่ะ");
                return;
            }

            // 🟨 ขั้นตอนกรอกชื่อ-นามสกุล
            if ($step === 'wait_name') {

                $email = cache()->get("line_email_" . $userId);
                $userModel = User::where('email', $email)->first();

                if ($userModel) {
                    $userModel->line_user_id = $userId;
                    $userModel->name = $message;
                    $userModel->save();

                    cache()->forget($cacheKey);
                    cache()->forget("line_email_" . $userId);
                    cache()->forget("email_attempts_" . $userId);

                    $this->replyMessage($replyToken, "ลงทะเบียนสำเร็จแล้วค่ะ 🎉");
                    return;
                }

                $this->replyMessage($replyToken, "เกิดข้อผิดพลาด ไม่พบข้อมูลผู้ใช้ค่ะ");
                return;
            }
        }
    }

}
