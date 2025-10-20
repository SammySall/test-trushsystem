<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TrashLocationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\GarbageController;
use App\Http\Controllers\TrashRequestController;
use App\Http\Controllers\Auth\RegisterController;
use Barryvdh\DomPDF\Facade\Pdf;


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

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

Route::get('/user/request/general', function () {
    return view('user.form_request.general');
});
Route::get('/user/request/trash_request', function () {
    return view('user.form_request.trash-request');
});
Route::get('/user/request/renew_license_engineer', function () {
    return view('user.form_request.renew-license-engineer');
});
Route::get('/user/request/health_hazard_license', function () {
    return view('user.form_request.health-hazard-license');
});

Route::get('/admin/emergency/dashboard', [EmergencyController::class, 'emergencyDashboard'])->name('admin.emergency.dashboard');
Route::get('/admin/emergency/{type}', [EmergencyController::class, 'emergencyList'])
    ->name('admin.emergency-list');
Route::get('/admin/emergency/{id}/detail', [EmergencyController::class, 'showDetail'])
    ->name('admin.emergency.detail');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/user/emergency/{type}', function ($type) {
    return view('user.emergency-page', ['type' => $type]);
});
Route::post('/user/emergency/submit', [EmergencyController::class, 'store'])->name('emergency.submit');

Route::get('/user/waste_payment', function () {
    return view('user.garbage');
});
Route::get('/user/waste_payment/trash-toxic', function () {
    return view('user.trash-toxic');
});
// Route::get('/user/waste_payment/check-payment', function () {
//     return view('user.check-payment-page');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/user/waste_payment/check-payment', [GarbageController::class, 'checkPayment'])->name('user.check-payment');
    Route::get('/bills/{id}/download', [GarbageController::class, 'downloadBill'])->name('bills.download');
});

Route::get('/user/waste_payment/status-trash', function () {
    return view('user.status-trash-page');
});

Route::get('/admin/waste_payment', [TrashLocationController::class, 'dashboard'])
    ->name('admin_trash.dashboard');

// Route::get('/admin/showdata', function () {
//     return view('admin_trash.showdata');
// });

Route::get('/admin/showdata', [TrashRequestController::class, 'showData'])->name('admin.showdata');
Route::post('/admin_trash/reply', [TrashRequestController::class, 'reply'])->name('admin_trash.reply');
Route::post('/admin/reply/{id}', [TrashRequestController::class, 'reply'])->name('admin.trash.reply');
Route::post('/trash-request/store', [TrashRequestController::class, 'store'])->name('trash-request.store');
Route::post('/admin/trash/accept', [TrashRequestController::class, 'accept'])->name('admin_trash.accept');
Route::get('/admin/trash/pdf/{id}', [TrashRequestController::class, 'showPdf'])->name('admin_trash.show_pdf');


Route::get('/admin/trash_can_installation', [TrashLocationController::class, 'index']);
Route::get('/admin/trash_can_installation/detail/{id}', [TrashLocationController::class, 'showCanInstallDetail']);
Route::post('/admin/trash_can_installation/{id}/confirm-payment', [TrashLocationController::class, 'confirmPayment']);

Route::get('/admin/trash_installer', [TrashLocationController::class, 'installerTrash']);
Route::get('/admin/trash_installer/detail/{id}', [TrashLocationController::class, 'showInstallerDetail']);

Route::get('/admin/verify_payment', [TrashLocationController::class, 'verifyPaymentsList'])
    ->name('admin.verify_payment');
Route::post('/admin/verify_payment/approve-bill', [TrashLocationController::class, 'approveBill'])
    ->name('admin.verify_payment.approveBill');

Route::get('/admin/payment_history', [TrashLocationController::class, 'paymentHistoryList'])
    ->name('admin.payment_history');
Route::get('/admin/payment_history/detail/{id}', [TrashLocationController::class, 'paymentHistoryDetail'])
    ->name('admin.payment_history.detail');

Route::get('/admin/non_payment', [TrashLocationController::class, 'nonPaymentList'])->name('admin.non_payment');
Route::get('/admin/non_payment/detail/{location}', [TrashLocationController::class, 'nonPaymentDetail'])
    ->name('non_payment.detail');
Route::get('/admin/non_payment/{trashLocationId}/export', [TrashLocationController::class, 'exportNonPaymentPdf'])
    ->name('admin.non_payment.export');
Route::post('/admin/non-payment/upload-slip', [TrashLocationController::class, 'uploadSlip'])->name('admin.non_payment.upload_slip');

use Illuminate\Support\Facades\Artisan;

Route::get('/link-storage', function () {
    Artisan::call('storage:link');
    return 'Storage link created!';
});

Route::fallback(function(){
    return view('notfound');
});