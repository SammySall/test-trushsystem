<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TrashLocationController;

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
    return view('welcome');
});
Route::get('/homepage', function () {
    return view('homepage');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/user/emergency', function () {
    return view('user.emergency-page');
});
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
