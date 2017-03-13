<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


//Route::get('queue', function(){
//    dispatch(new \App\Jobs\TestJob());
//});
//testing paystack payment gateway
//Route::get('paystack_test', 'PaymentController@testForm');

Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay');

Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');


Route::get('/install', 'HomeController@install')->name("install");
Route::post('/install', 'HomeController@setup');

Route::get('', 'Auth\LoginController@showLoginForm');

Route::get('/logout', function(){
    Auth::logout();
    return redirect('/');
});


Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::post('get_list_of_states/{country_id}', function($country_id){

       return \App\Country::with('states')->findOrFail($country_id)->states;
    });

    Route::post('get_list_of_lgas/{state_id}', function($state_id){

        return \App\State::with('lgas')->findOrFail($state_id)->lgas;
    });

    Route::post('get_guardian_id/{guardian_phone}', function(\Illuminate\Http\Request $request){

        $guardian = \App\Guardian::where('phone', '=', $request->phone)->first();

        if($guardian){
            return $guardian;

        }else{
            return 0;
        }
    });


    Route::group(['middleware' => 'admin'], function () {

        Route::get('add_licence', 'AdminController@licencePage')->name('Licence_page');

        Route::post('add_licence', 'AdminController@addLicence')->name('add_licence');

        Route::get('admin', 'AdminController@dashboard')->name('admin_dashboard');

        Route::get('admin/sessions', 'SessionController@index')->name('sessions');
        Route::post('admin/sessions/create', 'SessionController@store')->name('create_sessions');

        Route::put('admin/sessions/{session_id}/close', 'SessionController@closeSession')->name('close_session');

        Route::put('admin/sessions/{session_id}/start_first_term', 'SessionController@startFirstTerm')->name('start_first_term');
        Route::put('admin/sessions/{session_id}/close_first_term', 'SessionController@closeFirstTerm')->name('close_first_term');

        Route::put('admin/sessions/{session_id}/start_second_term', 'SessionController@startSecondTerm')->name('start_second_term');
        Route::put('admin/sessions/{session_id}/close_second_term', 'SessionController@closeSecondTerm')->name('close_second_term');

        Route::put('admin/sessions/{session_id}/start_third_term', 'SessionController@startThirdTerm')->name('start_third_term');
        Route::put('admin/sessions/{session_id}/close_third_term', 'SessionController@closeThirdTerm')->name('close_third_term');


        Route::get('admin/houses', 'HouseController@index')->name('admin_houses');
        Route::post('admin/houses', 'HouseController@store')->name('admin_houses_store');

        Route::get('admin/students', 'StudentController@index')->name('admin_students');
        Route::post('admin/students', 'StudentController@store')->name('admin_create_students');
        Route::get('admin/students/create', 'StudentController@create')->name('admin_create_students_form');
        Route::get('admin/students/{student_id}', 'AdminController@showStudent')->name('admin_students_show');
        Route::get('admin/students/{student_id}/results/session/{session_id}/view', 'AdminController@showStudentResult')->name('admin_students_show_results');
        Route::post('admin/students/{student_id}/results/session/{session_id}/update', 'AdminController@updateStudentResult')->name('admin_students_update_results');
        Route::post('admin/students/{student_id}/results/session/{session_id}/update_student_term_results_excel', 'AdminController@updateStudentTermResultsExcel')->name('admin_students_update_results');
        Route::get('admin/students/{student_id}/results', 'StudentController@showResults')->name('admin_students_print_results');
        Route::get('admin/students/{student_id}/results/session/{session_id}/edit', 'AdminController@editStudentResult')->name('admin_students_show_edit_results');
        Route::get('admin/students/{student_id}/edit', 'StudentController@edit')->name('admin_students_edit');
        Route::put('admin/students/{student_id}', 'StudentController@update')->name('admin_students_update');
        Route::delete('admin/students/{student_id}', 'StudentController@destroy')->name('admin_students_destroy');


        Route::get('admin/guardians', 'GuardianController@index')->name('admin_guardians');
        Route::get('admin/guardians/create', 'GuardianController@create')->name('admin_create_guardians_form');
        Route::post('admin/guardians', 'GuardianController@store')->name('admin_create_guardians');


        Route::get('admin/guardians/{guardian_id}', 'AdminController@showGuardian')->name('admin_guardians_show');

        Route::put('admin/guardians/{guardian_id}', 'GuardianController@update')->name('admin_guardians_update');
        Route::delete('admin/guardians/{guardian_id}', 'GuardianController@destroy')->name('admin_guardians_destroy');



        Route::get('admin/teachers', 'TeacherController@index')->name('admin_teachers');
        Route::get('admin/teachers/create', 'TeacherController@create')->name('admin_create_teacher_form');
        Route::post('admin/teachers', 'TeacherController@store')->name('admin_create_teacher');
        Route::get('admin/teachers/{teacher_id}', 'TeacherController@show')->name('admin_teachers_show');
        Route::get('admin/teachers/{teacher_id}/edit', 'TeacherController@edit')->name('admin_teachers_edit');
        Route::put('admin/teachers/{teacher_id}', 'TeacherController@update')->name('admin_teachers_update');
        Route::delete('admin/teachers/{teacher_id}', 'TeacherController@destroy')->name('admin_teachers_destroy');


        Route::get('admin/levels', 'LevelController@index')->name('admin_levels');
        Route::post('admin/levels', 'LevelController@store')->name('admin_levels_create');
        Route::get('admin/levels/{level_id}', 'LevelController@show')->name('admin_levels_show');
        Route::get('admin/levels/{level_id}/edit', 'LevelController@edit')->name('admin_levels_edit');
        Route::put('admin/levels/{level_id}', 'LevelController@update')->name('admin_levels_update');
        Route::delete('admin/levels/{level_id}', 'LevelController@destroy')->name('admin_levels_destroy');


        Route::get('admin/classrooms', 'ClassroomController@index')->name('admin_classrooms');
        Route::post('admin/classrooms', 'ClassroomController@store')->name('admin_create_classrooms');
        Route::get('admin/classrooms/{classroom_id}', 'ClassroomController@show')->name('admin_view_classroom');
        Route::put('admin/classrooms/{classroom_id}', 'ClassroomController@update')->name('admin_update_classroom');
        Route::delete('admin/classrooms/{classroom_id}/destroy', 'ClassroomController@destroy')->name('admin_delete_classroom');

        Route::get('admin/subjects', 'SubjectController@index')->name('admin_subjects');
        Route::post('admin/subjects', 'SubjectController@store')->name('admin_create_subjects');

        Route::post('admin/classroom_subjects', 'ClassroomSubjectController@store')->name('admin_create_classroomsubject');
        Route::put('admin/classroom_subjects/{classroomsubject_id}', 'ClassroomSubjectController@update')->name('admin_update_classroomsubject');

        Route::get('admin/results', 'AdminController@showResults')->name('admin_show_results');

        Route::get('admin/profile', 'AdminController@showProfile')->name('admin_profile');
        Route::put('admin/profile/reset_password', 'AdminController@resetPassword')->name('admin_reset_password');

        Route::get('admin/payments/upcoming', 'SchoolFeePaymentController@showUpcomingSchoolFee')->name('upcoming_payments');

    });





    Route::get('teacher', 'TeacherController@dashboard')->name('teacher_dashboard');
    Route::get('teacher/classrooms/{classroom_id}', 'TeacherController@showClassroom')->name('teacher_classroom');

    Route::put('teacher/classrooms/{classroom_id}/promote', 'TeacherController@promoteAllStudent')->name('teacher_promote_classroom');
    Route::put('teacher/classrooms/{classroom_id}/repeat', 'TeacherController@repeatAllStudent')->name('teacher_repeat_classroom');

    Route::put('teacher/classrooms/{classroom_id}/graduate', 'TeacherController@graduateAllStudent')->name('teacher_graduate_classroom');
    Route::put('teacher/classrooms/{classroom_id}/students/{student_id}/graduate', 'TeacherController@graduateStudent')->name('teacher_graduate_classroom');

    Route::put('teacher/classrooms/{classroom_id}/students/{student_id}/promote', 'TeacherController@promoteStudent')->name('teacher_promote_classroom');
    Route::put('teacher/classrooms/{classroom_id}/students/{student_id}/repeat', 'TeacherController@repeatStudent')->name('teacher_repeat_classroom');

    Route::get('teacher/classrooms/{classroom_id}/students/{student_id}', 'TeacherController@showStudent')->name('teacher_classroom_student');
    Route::get('teacher/classrooms/{classroom_id}/subjects/{subject_id}', 'TeacherController@showSubject')->name('teacher_classroom_subject');


    Route::post('teacher/classrooms/{classroom_id}/subjects/{subject_id}/students/{student_id}/results/create', 'TeacherController@storeStudentSubjectScore')->name('teacher_store_student_subject_scores');
    Route::get('teacher/classrooms/{classroom_id}/students/{student_id}/results', 'StudentController@showResults')->name('teacher_show_student_results_scores');


    Route::get('student', 'StudentController@dashboard')->name('student_dashboard');
    Route::get('student/academic_history', 'StudentController@showAcademicHistory')->name('student_academic_history');


    Route::get('guardian', 'GuardianController@dashboard');
    Route::get('guardian/payments', 'GuardianController@payments');
    Route::post('guardian/payments/current_school_fees', 'PaymentController@redirectToPaystackGateway')->name('pay_paystack');
    Route::get('guardian/payments/current_school_fee/callback', 'PaymentController@handleGatewayCallbackForCurrentSchoolFee');

    Route::get('guardian/wards', 'GuardianController@showWards');
    Route::get('guardian/wards/{student_id}', 'GuardianController@showWard');

    //Route::post('guardian/wards/{ward_id}/pay_school_fee', 'PaymentController@redirectToGateway')->name('pay');
    //Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');

    //Route::get('guardian/wards/{student_id}/results', 'GuardianController@showResult');

    Route::put('users/{user_id}/reset_password', 'UserController@resetPassword');




});







