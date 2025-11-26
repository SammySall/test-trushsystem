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

            // ตรวจสอบสถานะของผู้ใช้ในระบบ
            $cacheKey = "line_step_" . $userId;
            $step = cache()->get($cacheKey, 'ask_account_status');

            $user = User::where('line_user_id', $userId)->first();

            // ถ้าผู้ใช้มีบัญชีแล้ว
            if ($user) {
                $this->replyMessage($replyToken,
                    "😊 คุณมีบัญชีอยู่แล้วค่ะ\nดูข้อมูลเพิ่มเติมได้ที่นี่:\n" . url("/profile")
                );
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | STEP 1 — ถามว่า “มีบัญชีหรือยัง?”
            |--------------------------------------------------------------------------
            */
            if ($step === 'ask_account_status') {

                cache()->put($cacheKey, 'wait_account_status', 300);

                $quickReplies = [
                    [
                        "type" => "action",
                        "action" => [
                            "type" => "message",
                            "label" => "ใช่",
                            "text" => "ใช่"
                        ]
                    ],
                    [
                        "type" => "action",
                        "action" => [
                            "type" => "message",
                            "label" => "ยัง",
                            "text" => "ยัง"
                        ]
                    ]
                ];

                $this->replyMessage(
                    $replyToken,
                    "คุณมีบัญชีในระบบแล้วหรือยังคะ?",
                    $quickReplies
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | STEP 2 — ตรวจคำตอบ “ใช่” หรือ “ยัง”
            |--------------------------------------------------------------------------
            */
            if ($step === 'wait_account_status') {

                // ถ้าผู้ใช้ตอบว่า “ใช่” → ไปต่อขั้นตอนกรอกอีเมล
                if ($message === "ใช่") {

                    cache()->put($cacheKey, 'wait_email', 300);

                    $this->replyMessage(
                        $replyToken,
                        "กรุณากรอกอีเมลที่ใช้สมัครสมาชิกค่ะ 😊"
                    );

                    return;
                }

                // ถ้าตอบว่า “ยัง” → ส่งลิงก์สมัครทันที
                if ($message === "ยัง") {

                    $this->replyMessage(
                        $replyToken,
                        "คุณยังไม่มีบัญชีค่ะ\nสมัครสมาชิกได้ที่นี่เลยนะคะ:\n" . url("/register")
                    );

                    cache()->forget($cacheKey);
                    return;
                }

                // ตอบอย่างอื่น
                $this->replyMessage($replyToken, "กรุณาเลือกว่า “ใช่” หรือ “ยัง” ค่ะ");
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | STEP 3 — รับอีเมล
            |--------------------------------------------------------------------------
            */
            if ($step === 'wait_email') {

                $email = $message;

                $userCheck = User::where('email', $email)->first();
                $attemptKey = "email_attempts_" . $userId;
                $attempts   = cache()->get($attemptKey, 0);

                if (!$userCheck) {

                    $attempts++;
                    cache()->put($attemptKey, $attempts, 300);

                    if ($attempts >= 3) {

                        $this->replyMessage(
                            $replyToken,
                            "😢 ไม่พบอีเมลนี้ในระบบ\nกรุณาลงทะเบียนที่ลิงก์นี้ค่ะ:\n" . url("/register")
                        );

                        cache()->forget($attemptKey);
                        cache()->forget($cacheKey);
                        return;
                    }

                    $this->replyMessage(
                        $replyToken,
                        "ไม่พบอีเมลนี้ในระบบค่ะ 🙁\nคุณมีโอกาสอีก " . (3 - $attempts) . " ครั้งนะคะ"
                    );

                    return;
                }

                // เจออีเมล
                cache()->put("line_email_" . $userId, $email, 300);
                cache()->put($cacheKey, 'wait_name', 300);

                $this->replyMessage($replyToken, "กรุณาพิมพ์ ชื่อ - นามสกุล ค่ะ");

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | STEP 4 — รับชื่อ - นามสกุล
            |--------------------------------------------------------------------------
            */
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

                    $this->replyMessage($replyToken, "🎉 ลงทะเบียนสำเร็จแล้วค่ะ!");
                    return;
                }

                $this->replyMessage($replyToken, "เกิดข้อผิดพลาด ไม่พบข้อมูลผู้ใช้ค่ะ");
                return;
            }
        }
    }

}
