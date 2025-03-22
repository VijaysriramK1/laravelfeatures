<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

if (config('app.app_sync')) {
    Route::get('/', 'LandingController@index')->name('/');
}

if (moduleStatusCheck('Saas')) {
    Route::group(['middleware' => ['subdomain'], 'domain' => '{subdomain}.' . config('app.short_url')], function ($routes) {
        require('tenant.php');
    });

    Route::group(['middleware' => ['subdomain'], 'domain' => '{subdomain}'], function ($routes) {
        require('tenant.php');
    });
}

Route::group(['middleware' => ['subdomain']], function ($routes) {
    require('tenant.php');
});

Route::get('migrate', function () {
    if (Auth::check() && Auth::id() == 1) {
        Artisan::call('migrate', ['--force' => true]);
        \Brian2694\Toastr\Facades\Toastr::success('Migration run successfully');
        return redirect()->to(url('/admin-dashboard'));
    }
    abort(404);
});


 
Route::get('db-reset', function () {


    if (env('APP_ENV') == 'production') {
        return abort(404, 'You are not authorized to access this.');
    }

    if (Auth::check() && Auth::id() == 1) {
        Artisan::call('migrate:fresh', ['--force' => true]);
        \Brian2694\Toastr\Facades\Toastr::success('Database reset successfully');
        return redirect()->to(url('/admin-dashboard'));
    }
    abort(404);

   
});


Route::post('editor/upload-file', 'UploadFileController@upload_image');

Route::get('/lead-form-button', 'App\Http\Controllers\LeadFormController@ContactForm');

// 403 global routes
Route::get('/no-permission-access', function () {
    return view('errors.global403');
});

// student panel 403 routes
Route::get('/no-permission', function () {
    return view('errors.student403');
});

// student panel invoice routes
Route::get('/student-invoice-details/{id}', 'App\Http\Controllers\Student\StudentController@studentInvoiceDetails');

// unapproved student routes
Route::get('/student-class-list', 'App\Http\Controllers\Student\StudentController@studentClassList');
Route::get('/student-class-wise-section-list', 'App\Http\Controllers\Student\StudentController@studentClassWiseSectionList');
Route::get('/student-unapproved-list', 'App\Http\Controllers\Student\StudentController@unApprovedStudentDetails');
Route::get('/student-status-update/{id}/{status}', 'App\Http\Controllers\Student\StudentController@studentStatusUpdate');

// routines routes
Route::get('/selected-class-section-list', 'App\Http\Controllers\Programs\RoutinesController@classWiseSectionsDetailsDatatable');
Route::get('/selected-subject-teacher-list', 'App\Http\Controllers\Programs\RoutinesController@subjectWiseTeacherList');
Route::get('/calendar-view-data', 'App\Http\Controllers\Programs\RoutinesController@calendarViewData');

// lesson plan routes
Route::get('/lesson-plan-overview-search', 'App\Http\Controllers\Programs\RoutinesController@lessonPlanOverviewSearch');
Route::get('/lesson-plan-overview-status-update', 'App\Http\Controllers\Programs\RoutinesController@lessonPlanOverviewStatusUpdate');
Route::get('/lesson-plan-get-sub-topics', 'App\Http\Controllers\Programs\RoutinesController@LessonPlanGetSubTopics');
Route::get('/lesson-plan-adding', 'App\Http\Controllers\Programs\RoutinesController@LessonPlanAdding');

// student attendance routes
Route::get('/attendance-class-list', 'App\Http\Controllers\Student\AttendanceController@attendanceClassList')->name('attendance.class.list');
Route::get('/attendance-section-list', 'App\Http\Controllers\Student\AttendanceController@attendanceSectionList')->name('attendance.section.list');
Route::get('/admin-attendance-search', 'App\Http\Controllers\Student\AttendanceController@adminAttendanceSearch')->name('admin.attendance.search');
Route::get('/staff-attendance-search', 'App\Http\Controllers\Student\AttendanceController@staffAttendanceSearch')->name('staff.attendance.search');
Route::post('/class-section-wise-attendance-update', 'App\Http\Controllers\Student\AttendanceController@attendanceUpdate')->name('classsectionwise.attendance.update');
Route::post('/class-section-wise-attendance-request', 'App\Http\Controllers\Student\AttendanceController@attendanceRequest')->name('classsectionwise.attendance.request');
Route::post('/class-section-wise-attendance-status', 'App\Http\Controllers\Student\AttendanceController@attendanceStatus')->name('classsectionwise.attendance.status');
Route::get('/class-section-wise-attendance-details', 'App\Http\Controllers\Student\AttendanceController@classSectionWiseAttendanceRequestDetails')->name('classsectionwise.attendance.details');
Route::post('/attendance-request-update', 'App\Http\Controllers\Student\AttendanceController@attendanceRequestUpdate')->name('attendance.request.update');
Route::post('/attendance-request-delete', 'App\Http\Controllers\Student\AttendanceController@attendanceRequestDelete')->name('attendance.request.delete');
Route::get('/my-attendance-search', 'App\Http\Controllers\Student\AttendanceController@myAttendanceSearch')->name('my.attendance.search');

//scholarship
Route::get('/stipend-selected-class-section-list', 'App\Http\Controllers\Student\StipendController@selectedClassSectionList');
Route::get('/student-scholarship-search', 'App\Http\Controllers\Student\StipendController@studentScholarshipSearch');
Route::get('/student-stipend-adding', 'App\Http\Controllers\Student\StipendController@studentStipendAdding');
