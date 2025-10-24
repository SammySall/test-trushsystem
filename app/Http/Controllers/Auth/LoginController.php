<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;


class LoginController extends Controller
{
    // แสดงหน้า login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ตรวจสอบการล็อกอิน
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            $user = Auth::user();

            // สร้าง key สำหรับเข้าครั้งนี้
            $sessionKey = Str::random(20);

            // ข้อมูล token
            $tokenData = [
                'userId' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'address' => $user->address,
                'session_key' => $sessionKey,
                'login_at' => now()->toDateTimeString(),
            ];

            $encryptedToken = Crypt::encryptString(json_encode($tokenData));

            // เก็บ token ใน DB (optional)
            $user->api_token = $encryptedToken;
            $user->save();

            // ✅ เก็บ token ใน session → จะไม่หายเวลารีเฟรชหน้า
            session(['token' => $encryptedToken]);

            // redirect ตาม role
            if ($user->role === 'admin-trash') {
                return redirect('/admin/waste_payment');
            } elseif ($user->role === 'admin-emergency') {
                return redirect('/admin/emergency/dashboard');
            } elseif ($user->role === 'admin-health') {
                return redirect('/admin/request/public-health/appointment/health_hazard_license');
            } elseif ($user->role === 'admin-engineer') {
                return redirect('/admin/request/engineering/appointment/health_hazard_license');
            } elseif ($user->role === 'user') {
                return redirect('/homepage');
            } else {
                return redirect('/');
            }
        }

        return back()->with('error', 'อีเมลหรือรหัสผ่านไม่ถูกต้อง');
    }

    // ออกจากระบบ
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/homepage');
    }
}
