<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CourseController;
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
//homepage
Route::get('/', [UserController::class, 'Index'])->name('index');

//instructor registration
Route::get('/become/instructor', [AdminController::class, 'BecomeInstructor'])->name('become.instructor');
Route::POST('/register/instructor', [AdminController::class, 'RegisterInstructor'])->name('instructor.register');

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

//Category (ADMIN) Route
Route::controller(CategoryController::class)->group(function(){

    //Page route
    Route::get('/all/category','AllCategory')->name('all.category');
    Route::get('/add/category','AddCategory')->name('add.category');
    Route::get('/edit/category/{id}','EditCategory')->name('edit.category');

    //data route
    Route::POST('/category/store', 'StoreCategory')->name('store.category');
    Route::POST('/update/category', 'UpdateCategory')->name('update.category');
    Route::get('/delete/category/{id}','DeleteCategory')->name('delete.category');

});

//Sub-Category (ADMIN) Route
Route::controller(CategoryController::class)->group(function(){
    //Page route
    Route::get('/all/sub/category','AllSubCategory')->name('all.sub.category');
    Route::get('/add/sub/category','AddSubCategory')->name('add.sub.category');
    Route::get('/edit/sub/category/{id}','EditSubCategory')->name('edit.sub.category');
    //data route
    Route::POST('/sub/category/store', 'StoreSubCategory')->name('store.sub.category');
    Route::POST('/update/sub/category', 'UpdateSubCategory')->name('update.sub.category');
    Route::get('/delete/sub/category/{id}','DeleteSubCategory')->name('delete.sub.category');

});

//Manage Instructor (ADMIN)Route 
Route::controller(AdminController::class)->group(function(){
    //Page route
    Route::get('/all/instructor','AllInstructor')->name('all.instructor');
    //data route
    Route::POST('/update/instructor/status', 'UpdateInstructorStatus')->name('update.instructor.status');

});

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

// Manage Course (Instructor) Route 
Route::controller(CourseController::class)->group(function(){
    //Page route
    Route::get('/all/course','AllCourse')->name('all.course');
    Route::get('/add/course','AddCourse')->name('add.course');
    Route::get('/edit/course/{id}','EditCourse')->name('edit.course');
    //data route
    Route::get('/subcategory/ajax/{category_id}','GetSubCategory');
    Route::post('/store/course','StoreCourse')->name('store.course');
    Route::post('/update/course','UpdateCourse')->name('update.course');
    Route::post('/update/course/image','UpdateImageCourse')->name('update.course.image');
    Route::post('/update/course/video','UpdateVideoCourse')->name('update.course.video');
    Route::post('/update/course/goals','UpdateGoalCourse')->name('update.course.goal');
    Route::get('/delete/course/{id}','DeleteCourse')->name('delete.course');
});

}); //End of instructor group middleware

//PAGE-LOGIN
//adminLogin
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
//instructorLogin
Route::get('/instructor/login', [InstructorController::class, 'InstructorLogin'])->name('instructor.login');

