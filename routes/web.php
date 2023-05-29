<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tai-game', [AdminController::class,'TaiGame']);
Route::post('/tinh-tong', [AdminController::class,'TinhTong']);

//Show danh sách employees
Route::get('/show-danh-sach-employee', [AdminController::class,'ShowDanhSachEmployee'])->name('show.employee');

//Create employee
Route::get('/show-danh-sach-employee/tao-moi', [AdminController::class,'CreateEmployee'])->name('create.employee');
Route::post('/show-danh-sach-employee/tao-moi', [AdminController::class,'CreateEmployee'])->name('create.employee.post');

//Update employee
Route::get('/show-danh-sach-employee/chinh-sua/{id}', [AdminController::class,'EditEmployee'])->name('edit.employee');
Route::post('/show-danh-sach-employee/chinh-sua/{id}', [AdminController::class,'EditEmployee'])->name('edit.employee.post');

//Delete employee
Route::get('/show-danh-sach-employee/xoa/{id}', [AdminController::class,'DeleteEmployee'])->name('delete.employee');

//Search employee
Route::get('/show-danh-sach-employee/tim-kiem', [AdminController::class,'ShowDanhSachEmployee'])->name('search.employee');

// Export Data Employee
Route::post('/show-danh-sach-employee/export', [AdminController::class,'ExportEmployee'])->name('employee.export');