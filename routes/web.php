<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

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
    if(auth()->user()){
        auth()->user()->assignRole('admin');
    }
    return view('welcome');
});

Route::get('/tai-game', [AdminController::class,'TaiGame']);
Route::post('/tinh-tong', [AdminController::class,'TinhTong']);

//Nhóm quản lý employee
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

Route::get('dashboard',function(){return view('dashboard');})->name('dashboard');

// Nhóm route login, register, forgot password
// Hiển thị trang đăng kí 
Route::get('register',[AuthController::class,'registerView'])->name('register');
// Submit form đăng kí
Route::post('register/submit',[AuthController::class,'register'])->name('register.submit');
//  Hiển thị trang đăng nhập
Route::get('login',[AuthController::class,'loginView'])->name('login');
//  Submit form  đăng nhập
Route::post('login/submit',[AuthController::class,'login'])->name('login.submit');


//Nhóm quản lý Role
//Quản lý Role
Route::get('/show-danh-sach-role', [AdminController::class, 'ShowDanhSachRole'])->name('show.role');

//Create role
Route::get('/show-danh-sach-role/create', [AdminController::class, 'CreateViewRole'])->name('create.role');
Route::post('/show-danh-sach-role/create', [AdminController::class, 'CreateRole'])->name('create.role.post');

//Edit role
Route::get('/show-danh-sach-role/chinh-sua/{role}', [AdminController::class,'EditViewRole'])->name('edit.role');
Route::post('/show-danh-sach-role/chinh-sua/{role}', [AdminController::class,'EditRole'])->name('edit.role.post');

//Delete role
Route::get('/show-danh-sach-role/xoa/{role}', [AdminController::class,'DeleteRole'])->name('delete.role');


//Nhóm quản lý Permission
//Quản lý Permission
Route::get('/show-danh-sach-permission', [AdminController::class, 'ShowDanhSachPermission'])->name('show.permission');

//Create Permission
Route::get('/show-danh-sach-permission/create', [AdminController::class, 'CreateViewPermission'])->name('create.permission');
Route::post('/show-danh-sach-permission/create', [AdminController::class, 'CreatePermission'])->name('create.permission.post');

//Edit Permission
Route::get('/show-danh-sach-permission/chinh-sua/{permission}', [AdminController::class,'EditViewPermission'])->name('edit.permission');
Route::post('/show-danh-sach-permission/chinh-sua/{permission}', [AdminController::class,'EditPermission'])->name('edit.permission.post');

//Delete Permission
Route::get('/show-danh-sach-permission/xoa/{permission}', [AdminController::class,'DeletePermission'])->name('delete.permission');


//Nhóm quản lý User
Route::get('/show-danh-sach-user', [AdminController::class, 'ShowDanhSachUser'])->name('show.user');

//Create User
Route::get('/show-danh-sach-user/create', [AdminController::class, 'CreateViewUser'])->name('create.user');
Route::post('/show-danh-sach-user/create', [AdminController::class, 'CreateUser'])->name('create.user.post');

//Edit User
Route::get('/show-danh-sach-user/chinh-sua/{user}', [AdminController::class,'EditViewUser'])->name('edit.user');
Route::post('/show-danh-sach-user/chinh-sua/{user}', [AdminController::class,'EditUser'])->name('edit.user.post');

//Delete User
Route::get('/show-danh-sach-user/xoa/{user}', [AdminController::class,'DeleteUser'])->name('delete.user');
