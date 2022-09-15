<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\InvoiceSettingController;


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

Route::get('/', [HomeController::class,'index'])->middleware('auth');

Route::get('/students', [StudentController::class, 'index'])->middleware('auth')->name('students');
Route::get('/viewstudent/{id}', [StudentController::class, 'show'])->middleware('auth')->name('viewStudent');
Route::get('/addstudent', [StudentController::class, 'create'])->middleware('auth')->name('addstudent');
Route::post('/storestudent', [StudentController::class, 'store'])->middleware('auth')->name('storestudents');
Route::post('/edit-student/{id}', [StudentController::class, 'edit'])->middleware('auth')->name('editstudent');
Route::delete('/student-delete/{id}', [StudentController::class, 'destroy'])->middleware('auth')->name('students');
Route::post('/student-update', [StudentController::class, 'update'])->middleware('auth')->name('editstudent');
Route::post('/trafic-card-reference-letter/{id}', [StudentController::class, 'trafficCardReferenceLetter'])->middleware('auth')->name('students');
Route::post('/aptitude-test-reference-letter/{id}', [StudentController::class, 'aptitudeTestReferenceLetter'])->middleware('auth')->name('students');
Route::post('/second-aptitude-test-reference-letter/{id}', [StudentController::class, 'secondAptitudeTestReferenceLetter'])->middleware('auth')->name('students');
Route::post('/final-test-reference-letter/{id}', [StudentController::class, 'finalReferenceLetter'])->middleware('auth')->name('students');
Route::post('/lesson-report/{id}', [StudentController::class, 'lessonReport'])->middleware('auth')->name('students');

Route::get('/attendances', [AttendanceController::class, 'index'])->middleware('auth')->name('attendances');
Route::get('/addattendance', [AttendanceController::class, 'create'])->middleware('auth')->name('addattendance');
Route::post('/storeattendance', [AttendanceController::class, 'store'])->middleware('auth')->name('addattendance');
Route::post('/editattendance/{id}', [AttendanceController::class, 'edit'])->middleware('auth')->name('addattendance');
Route::post('/updateattendance', [AttendanceController::class, 'update'])->middleware('auth')->name('addattendance');
Route::delete('/deleteattendance/{id}', [AttendanceController::class, 'destroy'])->middleware('auth')->name('addattendance');
Route::get('/attendance-student-search', [AttendanceController::class, 'autocompletestudentSearch']);
Route::get('/attendance-student-search', [AttendanceController::class, 'autocompletestudentSearch'])->name('attendance-student-search');

Route::get('/courses', [CourseController::class, 'index'])->middleware('auth')->name('courses');
Route::get('/view-course/{id}', [CourseController::class, 'show'])->middleware('auth')->name('courses');
Route::get('/addcourse', [CourseController::class, 'create'])->middleware('auth')->name('addcourse');
Route::post('/storecourse', [CourseController::class, 'store'])->middleware('auth')->name('editcourse');
Route::post('/edit-course/{id}', [CourseController::class, 'edit'])->middleware('auth')->name('courses');
Route::delete('/delete-course/{id}', [CourseController::class, 'destroy'])->middleware('auth')->name('courses');
Route::post('/updatecourse', [CourseController::class, 'update'])->middleware('auth')->name('courses');

Route::get('/invoices', [InvoiceController::class, 'index'])->middleware('auth')->name('invoices');
Route::get('/view-invoice/{id}', [InvoiceController::class, 'show'])->middleware('auth')->name('dashboard');
Route::get('/addinvoice/{id}', [InvoiceController::class, 'create'])->middleware('auth')->name('invoices');
Route::post('/store-invoice', [InvoiceController::class, 'store'])->middleware('auth')->name('invoices');
Route::post('/edit-invoice/{id}', [InvoiceController::class, 'edit'])->middleware('auth')->name('invoices');
Route::delete('/invoice-delete/{id}', [InvoiceController::class, 'destroy'])->middleware('auth')->name('dashboard');
Route::post('/invoice-update', [InvoiceController::class, 'update'])->middleware('auth')->name('invoices');


Route::get('/instructors', [InstructorController::class, 'index'])->middleware('auth')->name('instructors');
Route::get('/viewinstructor', [InstructorController::class, 'show'])->middleware('auth')->name('instructors');
Route::get('/addinstructor', [InstructorController::class, 'create'])->middleware('auth')->name('instructors');
Route::post('/storeinstructor', [InstructorController::class, 'store'])->middleware('auth')->name('instructors');
Route::post('/editinstructor/{id}', [InstructorController::class, 'edit'])->middleware('auth')->name('instructors');
Route::post('/updateinstructor', [InstructorController::class, 'update'])->middleware('auth')->name('instructors');
Route::delete('/deleteinstructor/{id}', [InstructorController::class, 'destroy'])->middleware('auth')->name('instructors');

Route::get('/administrators', [AdministratorController::class, 'index'])->middleware('auth')->name('adminitrators');
Route::get('/viewadministrator', [AdministratorController::class, 'show'])->middleware('auth')->name('viewadministrator');
Route::get('/addadministrator', [AdministratorController::class, 'create'])->middleware('auth')->name('addadministrator');
Route::post('/storeadministrator', [AdministratorController::class, 'store'])->middleware('auth')->name('storeadministrator');
Route::post('/editadministrator/{id}', [AdministratorController::class, 'edit'])->middleware('auth')->name('editadministrator');
Route::post('/updateadministrator', [AdministratorController::class, 'update'])->middleware('auth')->name('updateadministrator');
Route::delete('/deleteadministrator/{id}', [AdministratorController::class, 'destroy'])->middleware('auth')->name('deleteadministrator');

Route::view('/fleet', 'fleet.fleet');
Route::view('/addfleet', 'fleet.addfleet');
Route::view('/editfleet', 'fleet.editfleet');
Route::view('/viewfleet', 'fleet.viewfleet');
Route::view('/deletefleet', '');

Route::get('/settings', [SettingController::class, 'edit'])->middleware('auth')->name('settings');
Route::post('/settings-update', [SettingController::class, 'update'])->middleware('auth')->name('settings');
Route::post('/invoicesettings-update', [InvoiceSettingController::class, 'update'])->middleware('auth')->name('settings');

Route::get('/super-admin-profile', [InstructorController::class, 'show-super-admin'])->middleware('auth')->name('super-admin-profile');
Route::get('/instructor-profile', [Controller::class, 'show-profile'])->middleware('auth')->name('instructor-profile');
Route::get('/admin-profile', [AdminController::class, 'show'])->middleware('auth')->name('admin-profile');




Route::get('/dashboard', [HomeController::class,'index'])->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
