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

Route::get('/admin/request/dashboard', function () {
    return view('admin_request.dashboard');
});

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
Route::get('/user/request/market_establishment_license', function () {
    return view('user.form_request.market-establishment-license');
});
Route::get('/user/request/food_sales_license', function () {
    return view('user.form_request.food-sales-license');
});
Route::get('/user/request/waste_disposal_business_license', function () {
    return view('user.form_request.waste-disposal-business-license');
});
Route::get('/user/request/new_license_engineer', function () {
    return view('user.form_request.new-license-engineer');
});

Route::middleware('auth')->get('/user/request/history_request/{type}', [TrashRequestController::class, 'historyRequest'])
    ->name('user.history-request');
Route::middleware('auth')->get('/user/request/history_request/{type}/{id}', [TrashRequestController::class, 'showUserRequestDetail'])
    ->name('user.history-request.detail');

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
Route::get('/user/request-emergency', function () {
    return view('user.request-emergency.emergency-menu');
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

Route::get('/bill/{bill}/pdf', [TrashRequestController::class, 'showPdfReceiptBill'])
    ->name('admin.bill.pdf');
Route::get('/license/{type}/pdf/{id}', [TrashRequestController::class, 'showLicensePdf'])
    ->name('admin_trash.license_pdf');


Route::get('/admin/showdata', [TrashRequestController::class, 'showData'])->name('admin.showdata');
Route::post('/admin/reply/{id}', [TrashRequestController::class, 'reply'])->name('admin.trash.reply');
Route::middleware('auth')->post('/trash-request/store', [TrashRequestController::class, 'store'])->name('trash-request.store');
Route::post('/admin/trash/accept', [TrashRequestController::class, 'accept'])->name('admin_trash.accept');
Route::get('/admin/trash/pdf/{id}', [TrashRequestController::class, 'showPdfTrash'])->name('admin_trash.show_pdf');
Route::get('/admin/request/public-health/appointment/{type}', [TrashRequestController::class, 'appointmentData'])
    ->name('admin.public-health.appointment');
Route::get('/admin/request/engineering/appointment/{type}', [TrashRequestController::class, 'appointmentDataEngineer'])
    ->name('admin.engineer.appointment');
Route::get('/admin/request/public-health/appointment/{type}/{id}', [TrashRequestController::class, 'appointmentDetail'])
    ->name('admin.public-health.appointment.detail');
Route::post('/admin/request/public-health/appointment/{id}', [TrashRequestController::class, 'appointmentStore'])
    ->name('admin.public-health.appointment.store');
Route::post('/user/history-request/confirm-appointment/{id}', [TrashRequestController::class, 'confirmAppointmentUser'])
    ->name('user.history.confirm-appointment');

Route::get('/admin/request/public-health/explore/{type}', [TrashRequestController::class, 'explore'])
    ->name('admin.public-health.explore');
Route::post('/admin/request/explore/{id}', [TrashRequestController::class, 'inspectionStore'])
    ->name('admin.request.explore.store');
Route::post('/user/history-request/upload-slip/{id}', [TrashRequestController::class, 'uploadSlipUser'])
    ->name('user.history.upload_slip')
    ->middleware('auth');

Route::get('/admin/request/public-health/Issue-a-license/{type}', [TrashRequestController::class, 'issueLicense'])
    ->name('admin.public-health.issue-license');
Route::post('/admin/request/public-health/upload-license/{id}', [TrashRequestController::class, 'uploadLicense'])
    ->name('admin.request.upload_license');
Route::post('/admin/request/public-health/save-license/{id}', [TrashRequestController::class, 'saveLicense'])->name('admin_trash.save_license');

Route::get('/admin/request/public-health/confirm_payment/{type}', 
    [TrashRequestController::class, 'confirmPaymentRequest'])
    ->name('admin.public-health.confirm_payment');
Route::post('/admin/request/public-health/confirm_payment/{id}', 
    [TrashRequestController::class, 'confirmPaymentRequestStore'])
    ->name('admin.public-health.confirm_payment.store');

Route::get('/admin/request/public-health/showdata/{type}', [TrashRequestController::class, 'showDataRequestHealth'])->name('admin.public-health.showdata');
Route::get('/admin/request/public-health/showdata/{type}/{id}', [TrashRequestController::class, 'showDetail'])
    ->name('admin_request.detail');
    
Route::get('/admin/request/engineering/showdata/{type}', [TrashRequestController::class, 'showDataRequestEngineer'])->name('admin.public-health.showdata');
Route::get('/admin/request/engineering/showdata/{type}/{id}', [TrashRequestController::class, 'showDetail'])
    ->name('admin_request.detail');

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

Route::get('/dev/reset', function () {
    try {
        // ล้างแคชทั้งหมด
        Artisan::call('optimize:clear');

        // รัน migrate refresh (รีเซ็ตฐานข้อมูลทั้งหมด)
        Artisan::call('migrate:refresh', ['--seed' => true]); // ถ้ามี seeder ด้วย

        return "<h3 style='color:green'>✅ Migrate & Optimize Clear สำเร็จ!</h3>
                <p>คำสั่งที่รัน:</p>
                <ul>
                    <li>php artisan optimize:clear</li>
                    <li>php artisan migrate:refresh --seed</li>
                </ul>";
    } catch (\Exception $e) {
        return "<h3 style='color:red'>❌ Error:</h3><pre>{$e->getMessage()}</pre>";
    }
});

Route::get('/link-storage', function () {
    Artisan::call('storage:link');
    return 'Storage link created!';
});

Route::fallback(function(){
    return view('notfound');
});