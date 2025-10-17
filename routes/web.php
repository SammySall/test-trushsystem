<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TrashLocationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmergencyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});
Route::get('/homepage', function () {
    return view('homepage');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/user/emergency/{value}', function ($value) {
    return view('user.emergency-page', ['value' => $value]);
});
Route::get('/user/emergency/{value}', [EmergencyController::class, 'show'])->name('emergency.show');
Route::post('/user/emergency/submit', [EmergencyController::class, 'store'])->name('emergency.submit');

Route::get('/user/waste_payment', function () {
    return view('user.garbage');
});
Route::get('/user/waste_payment/trash-toxic', function () {
    return view('user.trash-toxic');
});
Route::get('/user/waste_payment/check-payment', function () {
    return view('user.check-payment-page');
});
Route::get('/user/waste_payment/status-trash', function () {
    return view('user.status-trash-page');
});

Route::get('/admin/waste_payment', function () {
    return view('admin.dashboard');
});

Route::get('/admin/showdata', function () {
    return view('admin.showdata');
});

Route::get('/admin/trash_can_installation', [TrashLocationController::class, 'index']);
Route::get('/admin/trash_can_installation/detail/{id}', [TrashLocationController::class, 'showCanInstallDetail']);
Route::post('/admin/trash_can_installation/{id}/confirm-payment', [TrashLocationController::class, 'confirmPayment']);
// Route::get('/admin/trash_installer', function () {
//     return view('admin.trash-installer');
// });
Route::get('/admin/trash_installer', [TrashLocationController::class, 'installerTrash']);
Route::get('/admin/trash_installer/detail/{id}', [TrashLocationController::class, 'showInstallerDetail']);


Route::get('/admin/verify_payment', function () {
    return view('admin.verify_payment.check-payment');
});


Route::get('/admin/payment_history', function () {
    return view('admin.payment_history.payment-history');
});
Route::get('/admin/payment_history/detail', function () {
    return view('admin.payment_history.payment-history-detail');
});

Route::get('/admin/non_payment/detail', function () {
    return view('admin.non_payment.non-payment-detail');
});
Route::get('/admin/non_payment', function () {
    return view('admin.non_payment.non-payment');
});


Route::fallback(function(){
    return view('notfound');
});
