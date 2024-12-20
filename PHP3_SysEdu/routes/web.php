<?php

use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Client\StudentFeedbackController;
use App\Http\Controllers\Client\TuitionController;
use App\Http\Controllers\Teacher\TeacherFreeController;
use App\Http\Controllers\Teacher\TeacherScheduleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\EducationalHistoryController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentsController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\CreditController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Client\ScheduleController as ClientScheduleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\EnrollmentController as AdminEnrollmentController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Client\GradeController as ClientGradeController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\TimeSlotController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\HelpController;
use App\Http\Controllers\Client\HomeController as ClientHomeController;
use App\Http\Controllers\Teacher\HomeController as TeacherHomeController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Client\RegisterSubjectController;
use App\Http\Controllers\Admin\StudentSubjectClassController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\SubjectClassController;
use App\Http\Controllers\Client\ScoreController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\NewController;
use App\Http\Controllers\Admin\ScoreTypeController;
use App\Http\Controllers\Admin\SubjectLecturerController;
use App\Http\Controllers\Teacher\StudentLookupController;
use App\Http\Controllers\Admin\TeacherFreeSlotController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Admin\ExamScheduleController;

use App\Http\Controllers\Client\HomeController;
use App\Http\Middleware\CorsMiddleware;

//MajorName=================================================================================

Route::prefix('majors')->group(function () {
    Route::get('/list', [MajorController::class, 'list']);
});

//Enrollments===============================================================================

Route::prefix('enrollments')->group(function () {
    Route::get('/', [EnrollmentController::class, 'index']);
    // Route::get('/{id}', [EnrollmentController::class, 'show']); 
    Route::post('/', [EnrollmentController::class, 'store']);
    // Route::put('/{id}', [EnrollmentController::class, 'update']); 
    // Route::delete('/{id}', [EnrollmentController::class, 'destroy']);
});

//News======================================================================================

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
    Route::get('/{id}', [NewsController::class, 'show']);
    Route::post('/', [NewsController::class, 'store']);
    Route::put('/{id}', [NewsController::class, 'update']);
    Route::delete('/{id}', [NewsController::class, 'destroy']);
});

// auth route ==============================================================================
Route::get('/', [LoginController::class, 'index'])->name('login');

Route::prefix('auth/login')->group(function () {
    // Admin
    Route::get('admin', [LoginController::class, 'loginAdmin'])->name('login.admin');
    Route::get('admin/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login.admin');

    // Teacher  
    Route::get('teacher', [LoginController::class, 'loginTeacher'])->name('login.teacher');
    Route::get('teacher/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login.teacher');

    // Student
    Route::get('student', [LoginController::class, 'loginStudent'])->name('login.student');
    Route::get('student/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login.student');
});

Route::get('auth/callback/google', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('my-profile', [ProfileController::class, 'profileTeacher'])->name('teacher.profile');
Route::get('profile', [ProfileController::class, 'profileEmployee'])->name('admin.profile');
Route::get('ho-so', [ProfileController::class, 'profileStudent'])->name('profile');

Route::post('/logout', [LogoutController::class, 'logoutEmployee'])->name('employee.logout');
Route::post('/dang-xuat', [LogoutController::class, 'logoutStudent'])->name('logout');
//end auth route ==============================================================================


// admin route ==============================================================================
Route::middleware(['admin'])->group(function () {
    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('faculties')->name('admin.faculties.')->group(function () {
        Route::get('/', [FacultyController::class, 'index'])->name('index');
        Route::get('create', [FacultyController::class, 'create'])->name('create');
        Route::post('create', [FacultyController::class, 'store'])->name('create.post');
        Route::get('edit/{id}', [FacultyController::class, 'edit'])->name('edit');
        Route::put('{id}', [FacultyController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [FacultyController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('majors')->name('admin.majors.')->group(function () {
        Route::get('/', [MajorController::class, 'index'])->name('index');
        Route::get('create', [MajorController::class, 'create'])->name('create');
        Route::post('create', [MajorController::class, 'store'])->name('create.post');
        Route::get('edit/{id}', [MajorController::class, 'edit'])->name('edit');
        Route::put('{id}', [MajorController::class, 'update'])->name('update');
        Route::delete('{id}', [MajorController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('classes')->name('admin.classes.')->group(function () {
        Route::get('/', [ClassController::class, 'index'])->name('index');
        Route::get('detail/{majorClassId}', [ClassController::class, 'showClassDetail'])->name('detail');
        Route::get('create', [ClassController::class, 'create'])->name('create');
        Route::post('create', [ClassController::class, 'store'])->name('create.post');
        Route::get('edit/{id}', [ClassController::class, 'edit'])->name('edit');
        Route::put('{id}', [ClassController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ClassController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/update-status', [ClassController::class, 'updateStatus'])->name('updateStatus');
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
        Route::get('detail/{id}', [EmployeeController::class, 'showDetail'])->name('detail');
        Route::post('updateSubjects/{id}', [EmployeeController::class, 'updateSubjects'])->name('updateSubjects');
    });

    Route::prefix('students')->name('admin.students.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('create', [StudentController::class, 'create'])->name('create');
        Route::post('create', [StudentController::class, 'store'])->name('create.post');
        Route::get('edit/{id}', [StudentController::class, 'edit'])->name('edit');
        Route::put('{id}', [StudentController::class, 'update'])->name('update');
        Route::delete('{id}', [StudentController::class, 'destroy'])->name('destroy');
        Route::get('detail/{id}', [StudentController::class, 'showDetail'])->name('detail');
    });

    Route::prefix('schedules')->name('admin.schedules.')->group(function () {
        Route::get('view-schedule/{subject_class_id}', [AdminScheduleController::class, 'viewSchedule'])->name('view-schedule');
        Route::get('create', [AdminScheduleController::class, 'create'])->name('create');
        Route::post('create', [AdminScheduleController::class, 'store'])->name('create.post');
        Route::get('edit/{id}', [AdminScheduleController::class, 'edit'])->name('edit');
        Route::put('{id}', [AdminScheduleController::class, 'update'])->name('update');
        Route::get('/export-schedules-pdf', [AdminScheduleController::class, 'exportPdf'])->name('export-pdf');
    });

    Route::prefix('examschedules')->name('admin.examschedules.')->group(function () {
        Route::get('index', [ExamScheduleController::class, 'index'])->name('index');
        Route::get('show/{id}', [ExamScheduleController::class, 'show'])->name('show');
        Route::get('create', [ExamScheduleController::class, 'create'])->name('create');
        Route::post('create', [ExamScheduleController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ExamScheduleController::class, 'edit'])->name('edit');
        Route::put('{id}', [ExamScheduleController::class, 'update'])->name('update');
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
        Route::get('/{id}/edit', [NotificationController::class, 'edit'])->name('edit');
        Route::put('/{id}/edit', [NotificationController::class, 'update'])->name('update');
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
        Route::get('{id}', [SubjectController::class, 'detail'])->name('detail');
    });

    Route::prefix('studentsubjectclass')->name('admin.studentsubjectclass.')->group(function () {
        Route::get('{id}', [StudentSubjectClassController::class, 'index'])->name('index');
        Route::get('edit/{id}', [StudentSubjectClassController::class, 'edit'])->name('edit');
        Route::put('{id}', [StudentSubjectClassController::class, 'update'])->name('update');
        Route::post('import/{id}', [StudentSubjectClassController::class, 'import'])->name('import');
        Route::get('export/{id}', [StudentSubjectClassController::class, 'export'])->name('export');
    });

    Route::prefix('subjectclasses')->name('admin.subjectclasses.')->group(function () {
        Route::get('/', [SubjectClassController::class, 'index'])->name('index');
        Route::get('create', [SubjectClassController::class, 'create'])->name('create');
        Route::post('create', [SubjectClassController::class, 'store'])->name('create.post');
        Route::get('edit/{id}', [SubjectClassController::class, 'edit'])->name('edit');
        Route::put('{id}', [SubjectClassController::class, 'update'])->name('update');
        Route::delete('{id}', [SubjectClassController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('feedbacks')->name('admin.feedbacks.')->group(function () {
        Route::get('/', [FeedbackController::class, 'index'])->name('index');
        Route::get('/create', [FeedbackController::class, 'create'])->name('create');
        Route::post('/store', [FeedbackController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [FeedbackController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [FeedbackController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [FeedbackController::class, 'destroy'])->name('delete');
    });

    Route::prefix('credits')->name('admin.credits.')->group(function () {
        Route::get('/', [CreditController::class, 'index'])->name('index');
        Route::get('create', [CreditController::class, 'create'])->name('create');
        Route::post('create', [CreditController::class, 'store'])->name('store.post');
        Route::get('edit/{id}', [CreditController::class, 'edit'])->name('edit');
        Route::put('{id}', [CreditController::class, 'update'])->name('update');
        Route::delete('{id}', [CreditController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('scoreTypes')->name('admin.score_types.')->group(function () {
        Route::get('/', [ScoreTypeController::class, 'index'])->name('index');
        Route::get('create', [ScoreTypeController::class, 'create'])->name('create');
        Route::post('create', [ScoreTypeController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ScoreTypeController::class, 'edit'])->name('edit');
        Route::put('{id}', [ScoreTypeController::class, 'update'])->name('update');
        Route::delete('{id}', [ScoreTypeController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin')->name('admin.subject_lecturers.')->group(function () {
        Route::get('subject-lecturers', [SubjectLecturerController::class, 'create'])->name('create');
        Route::post('subject-lecturers', [SubjectLecturerController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        Route::get('subject-lecturers/filter', [SubjectLecturerController::class, 'filter'])->name('filter');
    });

    Route::prefix('teacherFreeSlot')->name('admin.teacher_free_slots.')->group(function () {
        Route::get('/', [TeacherFreeSlotController::class, 'index'])->name('index');
        Route::get('update/{id}', [TeacherFreeSlotController::class, 'createOrUpdate'])->name('createOrUpdate');
        Route::post('update/{id}', [TeacherFreeSlotController::class, 'storeOrUpdate'])->name('storeOrUpdate');
    });

    Route::prefix('news-admin')->name('admin.news.')->group(function () {
        Route::get('/', [NewController::class, 'index'])->name('index');
        Route::get('create', [NewController::class, 'create'])->name('create');
        Route::post('store', [NewController::class, 'store'])->name('store');
        Route::get('edit/{id}', [NewController::class, 'edit'])->name('edit');
        Route::put('{id}', [NewController::class, 'update'])->name('update');
        Route::delete('{id}', [NewController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('enrollments')->name('admin.enrollments.')->group(function () {
        Route::get('/', [AdminEnrollmentController::class, 'index'])->name('index');
        Route::get('detail/{id}', [AdminEnrollmentController::class, 'detail'])->name('detail');
        Route::delete('{id}', [AdminEnrollmentController::class, 'destroy'])->name('destroy');
    });
    // Ajax
    Route::get('/majors-by-faculty', [DashboardController::class, 'getMajorsByFaculty'])->name('majors.by.faculty');
    Route::get('admin/lecturers-by-subject', [SubjectLecturerController::class, 'getLecturersBySubject'])->name('admin.lecturers.by.subject');
    Route::get('admin/majorclasses-by-subject', [ClassController::class, 'getMajorClassesBySubject'])->name('admin.majorclasses.by.subject');
});

//end admin route ==============================================================================

Route::middleware(['student'])->group(function () {

    Route::get('trang-chu', [ClientHomeController::class, 'index'])->name('home');
    Route::get('thong-bao/{id}', [ClientHomeController::class, 'show'])->name('notifications.detail');

    Route::get('thanh-toan', [TuitionController::class, 'index'])->name('tuition');

    // Route::get('/generate-vietqr', [HomeController::class, 'generateVietQr'])->name('vietqr');
    Route::get('/generate-vietqr/{studentId}', [TuitionController::class, 'generateVietQr'])->name('vietqr');

    Route::get('diem', [ClientGradeController::class, 'index'])->name('grades');

    Route::get('lich-hoc', [ClientScheduleController::class, 'index'])->name('schedules');

    Route::get('ho-tro', [HelpController::class, 'index'])->name('help');

    Route::get('dang-ky-mon', [RegisterSubjectController::class, 'index'])->name('register-subject');
    Route::get('mon-hoc/{id}/lop', [RegisterSubjectController::class, 'detailSubjectById'])->name('client.subject.classes.show');
    Route::post('tham-gia-lop/{id}', [RegisterSubjectController::class, 'joinClass'])->name('joinClass');
    Route::post('/lop-mon/huy-dang-ky/{id}', [RegisterSubjectController::class, 'cancelClass'])->name('cancelClass');

    Route::get('lich-su-hoc', [EducationalHistoryController::class, 'index'])->name('educational-history');

    Route::get('/bang-diem-theo-ky', [ScoreController::class, 'index'])->name('scores');

    Route::get('feedback', [StudentFeedbackController::class, 'index'])->name('feedback.list');
    Route::get('feedback/{studentSubjectClassId}/form', [StudentFeedbackController::class, 'showFeedbackForm'])->name('student.feedback.form');
    Route::post('feedback/{studentSubjectClassId}/store', [StudentFeedbackController::class, 'storeFeedback'])->name('feedback.store');
});

//teacher
Route::middleware(['teacher'])->group(function () {

    Route::prefix('gv')->group(function () {
        Route::get('/', [TeacherHomeController::class, 'index'])->name('teacher.home');
        Route::get('/notifications/{id}', [TeacherHomeController::class, 'show'])->name('notifications.show');

        Route::get('/student-lookup', [StudentLookupController::class, 'index'])->name('student.index');
        Route::get('/student-lookup/search', [StudentLookupController::class, 'search'])->name('student.search');
        Route::get('/student-lookup/{id}', [StudentLookupController::class, 'show'])->name('student.show');
        Route::get('/schedules', [TeacherScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/schedules/filter', [TeacherScheduleController::class, 'filter'])->name('teacher.schedules.filter');
        Route::get('/free-slot', [TeacherFreeController::class, 'index'])->name('teacher.free_slot.index');
        Route::post('/free-slot', [TeacherFreeController::class, 'update'])->name('teacher.free_slot.update');

        Route::prefix('classes')->group(function () {
            Route::get('/', [AttendanceController::class, 'classList'])->name('classes');
            Route::get('/{subjectClass}', [AttendanceController::class, 'classDetail'])->name('attendance.class.detail');
            Route::get('/{subjectClass}/attendance', [AttendanceController::class, 'takeAttendance'])->name('attendance.take');
            Route::post('/{subjectClass}/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
            Route::post('/{subjectClass}/import', [AttendanceController::class, 'importGrades'])->name('attendance.import');
            Route::get('/{subjectClass}/export', [AttendanceController::class, 'exportGrades'])->name('attendance.export');
            Route::get('/{subjectClass}/export-exam-list', [AttendanceController::class, 'exportExamList'])->name('export.examList');
        });
    });
});
