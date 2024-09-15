<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\EducationalHistoryController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentsController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Client\ScheduleController as ClientScheduleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Client\GradeController as ClientGradeController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\TimeSlotController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\HelpController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Client\RegisterSubjectController;
use App\Http\Controllers\Admin\StudentSubjectClassController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\SubjectClassController;

// auth route ==============================================================================
Route::get('/', function () {
    return view('auth.loginPortal');
});

Route::get('login-employee', [LoginController::class, 'loginEmployee'])->name('auth.employee');
Route::get('login-student', [LoginController::class, 'loginStudent'])->name('auth.student');

Route::prefix('auth')->group(function () {
    // Login by Google Employee
    Route::get('redirect/google/employee', [GoogleController::class, 'redirectToGoogle'])->name('auth.google.employee');
    // Login by Google Student
    Route::get('redirect/google/student', [GoogleController::class, 'redirectToGoogle'])->name('auth.google.student');
    Route::get('callback/google', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});


Route::get('profile', [ProfileController::class, 'profileEmployee'])->name('admin.profile');
Route::get('ho-so', [ProfileController::class, 'profileStudent'])->name('profile');

Route::post('/logout', [LogoutController::class, 'logoutEmployee'])->name('admin.logout');
Route::post('/dang-xuat', [LogoutController::class, 'logoutStudent'])->name('logout');
//end auth route ==============================================================================





// admin route ==============================================================================

Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/majors-by-faculty', [DashboardController::class, 'getMajorsByFaculty'])->name('majors.by.faculty');

Route::prefix('faculties')->name('admin.faculties.')->group(function () {
    Route::get('/', [FacultyController::class, 'index'])->name('index');
    Route::get('create', [FacultyController::class, 'create'])->name('create');
    Route::post('create', [FacultyController::class, 'store'])->name('create.post');
    Route::get('edit/{id}', [FacultyController::class, 'edit'])->name('edit');
    Route::put('{id}', [FacultyController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [FacultyController::class, 'destroy'])->name('delete');
});

Route::prefix('majors')->name('admin.majors.')->group(function () {
    Route::get('/', [MajorController::class, 'index'])->name('index');
    Route::get('create', [MajorController::class, 'create'])->name('create');
    Route::post('create', [MajorController::class, 'store'])->name('create.post');
    Route::get('edit/{id}', [MajorController::class, 'edit'])->name('edit');
    Route::put('{id}', [MajorController::class, 'update'])->name('update');
    Route::delete('{id}', [MajorController::class, 'destroy'])->name('destroy');
});

Route::prefix('subjects')->name('admin.subjects.')->group(function () {
    Route::get('/', [SubjectController::class, 'index'])->name('index');
    Route::get('create', [SubjectController::class, 'create'])->name('create');
    Route::get('edit/{id}', [SubjectController::class, 'edit'])->name('edit');
});

Route::name('admin.')->group(function () {
    Route::get('Faculties', [ClassController::class, 'showFaculties'])->name('faculties');
    Route::get('Faculty/Majors/{id}', [ClassController::class, 'showMajors'])->name('majors');
    Route::get('Faculty/Major/Classes/{id}', [ClassController::class, 'showClasses'])->name('classes');
    Route::get('Faculty/Major/Classes/create/{id}', [ClassController::class, 'create'])->name('create');
    Route::post('Faculty/Major/Classes/create', [ClassController::class, 'store'])->name('create.post');
    Route::get('Faculty/Major/Classes/edit/{id}', [ClassController::class, 'edit'])->name('edit');
    Route::put('Faculty/Major/Classes/update/{id}', [ClassController::class, 'update'])->name('update');
    Route::delete('Faculty/Major/Classes/delete/{id}', [ClassController::class, 'destroy'])->name('destroy');
    Route::put('Faculty/Major/Classes/{id}/update-status', [ClassController::class, 'updateStatus'])->name('updateStatus');
});

Route::prefix('classes')->name('admin.classes.')->group(function () {
    Route::get('/', [ClassController::class, 'index'])->name('index');
    Route::get('create', [ClassController::class, 'create'])->name('create');
    Route::get('edit/{id}', [ClassController::class, 'edit'])->name('edit');
});

Route::prefix('employees')->name('admin.employees.')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::get('create', [EmployeeController::class, 'create'])->name('create');
    Route::post('create', [EmployeeController::class, 'store'])->name('create.post');
    Route::get('edit/{id}', [EmployeeController::class, 'edit'])->name('edit');
    Route::put('/{id}', [EmployeeController::class, 'update'])->name('update');
    Route::delete('{id}', [EmployeeController::class, 'destroy'])->name('destroy');
});

Route::prefix('students')->name('admin.students.')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('index');
    Route::get('create', [StudentController::class, 'create'])->name('create');
    Route::post('create', [StudentController::class, 'store'])->name('create.post');
    Route::get('edit/{id}', [StudentController::class, 'edit'])->name('edit');
    Route::put('{id}', [StudentController::class, 'update'])->name('update');
    Route::delete('{id}', [StudentController::class, 'destroy'])->name('destroy');
});

Route::prefix('schedules')->name('admin.schedules.')->group(function () {
    Route::get('/', [AdminScheduleController::class, 'index'])->name('index');
    Route::get('select-semester', [AdminScheduleController::class, 'selectSemester'])->name('select.semester');
    Route::get('create/{semesterId?}', [AdminScheduleController::class, 'create'])->name('create');
    Route::post('create', [AdminScheduleController::class, 'store'])->name('create.post');
    Route::get('edit/{id}', [AdminScheduleController::class, 'edit'])->name('edit');
    Route::put('{id}', [AdminScheduleController::class, 'update'])->name('update');
    Route::delete('{id}', [AdminScheduleController::class, 'destroy'])->name('destroy');
});

Route::prefix('semesters')->name('admin.semesters.')->group(function () {
    Route::get('/', [SemesterController::class, 'index'])->name('index');
    Route::get('create', [SemesterController::class, 'create'])->name('create');
    Route::post('create', [SemesterController::class, 'store'])->name('create.post');
    Route::get('edit/{id}', [SemesterController::class, 'edit'])->name('edit');
    Route::put('{id}', [SemesterController::class, 'update'])->name('update');
    Route::delete('{id}', [SemesterController::class, 'destroy'])->name('destroy');
});

Route::prefix('departments')->name('admin.departments.')->group(function () {
    Route::get('/', [DepartmentsController::class, 'index'])->name('index');
    Route::get('create', [DepartmentsController::class, 'create'])->name('create');
    Route::post('create', [DepartmentsController::class, 'store'])->name('create.post');
    Route::get('edit/{id}', [DepartmentsController::class, 'edit'])->name('edit');
    Route::put('{id}', [DepartmentsController::class, 'update'])->name('update');
    Route::delete('{id}', [DepartmentsController::class, 'destroy'])->name('destroy');
});
Route::prefix('classrooms')->name('admin.classrooms.')->group(function () {
    Route::get('/', [ClassroomController::class, 'index'])->name('index');
    Route::get('create', [ClassroomController::class, 'create'])->name('create');
    Route::post('create', [ClassroomController::class, 'store'])->name('create.post');
    Route::get('edit/{id}', [ClassroomController::class, 'edit'])->name('edit');
    Route::put('{id}', [ClassroomController::class, 'update'])->name('update');
    Route::delete('{id}', [ClassroomController::class, 'destroy'])->name('destroy');
});



Route::prefix('notifications')->name('admin.notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::post('send', [NotificationController::class, 'send'])->name('send');
    Route::get('detail/{id}', [NotificationController::class, 'detail'])->name('detail');
});


Route::prefix('timeslots')->name('admin.timeslots.')->group(function () {
    Route::get('/', [TimeSlotController::class, 'index'])->name('index');
    Route::get('create', [TimeSlotController::class, 'create'])->name('create');
    Route::post('create', [TimeSlotController::class, 'store'])->name('create.post');
    Route::get('edit/{id}', [TimeSlotController::class, 'edit'])->name('edit');
    Route::put('{id}', [TimeSlotController::class, 'update'])->name('update');
    Route::delete('{id}', [TimeSlotController::class, 'destroy'])->name('destroy');
});

Route::prefix('subjects')->name('admin.subjects.')->group(function () {
    Route::get('/', [SubjectController::class, 'index'])->name('index');
    Route::get('create', [SubjectController::class, 'create'])->name('create');
    Route::post('create', [SubjectController::class, 'store'])->name('create.post');
    Route::get('edit/{id}', [SubjectController::class, 'edit'])->name('edit');
    Route::put('{id}', [SubjectController::class, 'update'])->name('update');
    Route::delete('{id}', [SubjectController::class, 'destroy'])->name('destroy');

});

Route::prefix('studentsubjectclass')->name('admin.studentsubjectclass.')->group(function () {
    Route::get('/', [StudentSubjectClassController::class, 'index'])->name('index');
    // Route::get('create', [StudentSubClassController::class, 'create'])->name('create');
    // Route::post('create', [StudentSubClassController::class, 'store'])->name('create.post');
    Route::get('edit/{id}', [StudentSubjectClassController::class, 'edit'])->name('edit');
    Route::put('{id}', [StudentSubjectClassController::class, 'update'])->name('update');
});

Route::prefix('subjectclasses')->name('admin.subjectclasses.')->group(function () {
    Route::get('/', [SubjectClassController::class, 'index'])->name('index');
    Route::get('create', [SubjectClassController::class, 'create'])->name('create');
    Route::post('create', [SubjectClassController::class, 'store'])->name('create.post');
    Route::get('edit/{id}', [SubjectClassController::class, 'edit'])->name('edit');
    Route::put('{id}', [SubjectClassController::class, 'update'])->name('update');
    Route::delete('{id}', [SubjectClassController::class, 'destroy'])->name('destroy');

});

//end admin route ==============================================================================



Route::get('trang-chu', [HomeController::class, 'index'])->name('home');

Route::get('diem', [ClientGradeController::class, 'index'])->name('grades');

Route::get('lich-hoc', [ClientScheduleController::class, 'index'])->name('schedules');

Route::get('ho-tro', [HelpController::class, 'index'])->name('help');

Route::get('dang-ky-mon', [RegisterSubjectController::class, 'index'])->name('register-subject');
Route::get('mon-hoc/{id}/lop', [RegisterSubjectController::class, 'detailSubjectById'])->name('client.subject.classes.show');
Route::post('tham-gia-lop/{id}', [RegisterSubjectController::class, 'joinClass'])->name('joinClass');
Route::post('/lop-mon/huy-dang-ky/{id}', [RegisterSubjectController::class, 'cancelClass'])->name('cancelClass');

Route::get('lich-su-hoc', [EducationalHistoryController::class, 'index'])->name('educational-history');