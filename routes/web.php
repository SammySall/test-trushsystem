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
    return view('user.emergencypage');
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
Route::get('/admin/detail/{id}', [TrashLocationController::class, 'show']);
Route::post('/admin/trash_can_installation/{id}/confirm-payment', [TrashLocationController::class, 'confirmPayment']);

Route::get('/admin/trash_installer', function () {
    return view('admin.trashinstaller');
});

Route::fallback(function(){
    return view('notfound');
});
