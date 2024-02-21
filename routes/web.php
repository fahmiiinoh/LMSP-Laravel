<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [UserController::class, 'Index'])->name('index');

//user group middleware
Route::get('/dashboard', function () {
    return view('frontend.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //page route
    Route::get('/dashboard/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::get('/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    //user logout
    Route::get('/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    //data route
    Route::POST('/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::POST('/update/password', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');

});

require __DIR__.'/auth.php';


//ADMIN Group Middleware
Route::middleware(['auth','roles:admin'])->group(function(){

//redirect to admin dashboard
Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
//admin logout
Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
//page route
Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
//data route
Route::POST('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
Route::POST('/admin/update/password', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');



}); //End of ADMIN group middleware

//Instructor Group Middleware
Route::middleware(['auth','roles:instructor'])->group(function(){
//redirect to instructor dashboard
Route::get('/instructor/dashboard', [InstructorController::class, 'InstructorDashboard'])->name('instructor.dashboard');
Route::get('/instructor/logout', [InstructorController::class, 'InstructorLogout'])->name('instructor.logout');
//page route
Route::get('/instructor/profile', [InstructorController::class, 'InstructorProfile'])->name('instructor.profile');
Route::get('/instructor/change/password', [InstructorController::class, 'InstructorChangePassword'])->name('instructor.change.password');
//data route
Route::POST('/instructor/profile/store', [InstructorController::class, 'InstructorProfileStore'])->name('instructor.profile.store');
Route::POST('/instructor/update/password', [InstructorController::class, 'InstructorPasswordUpdate'])->name('instructor.password.update');

}); //End of instructor group middleware


//adminLogin
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
//instructorLogin
Route::get('/instructor/login', [InstructorController::class, 'InstructorLogin'])->name('instructor.login');