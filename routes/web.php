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

Route::get('/admin/waste_payment', function () {
    return view('dashboard');
});

Route::get('/admin/showdata', function () {
    return view('showdata');
});

Route::get('/admin/trash_can_installation', [TrashLocationController::class, 'index']);
Route::get('/admin/detail/{id}', [TrashLocationController::class, 'show']);
Route::post('/admin/trash_can_installation/{id}/confirm-payment', [TrashLocationController::class, 'confirmPayment']);

Route::get('/admin/trash_installer', function () {
    return view('trashinstaller');
});

Route::fallback(function(){
    return view('notfound');
});
