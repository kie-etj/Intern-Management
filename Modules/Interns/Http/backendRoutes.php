<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/interns'], function (Router $router) {
    $router->bind('school', function ($id) {
        return app('Modules\Interns\Repositories\SchoolRepository')->find($id);
    });
    $router->get('schools', [
        'as' => 'admin.interns.school.index',
        'uses' => 'SchoolController@index',
        'middleware' => 'can:interns.schools.index'
    ]);
    $router->get('schools/create', [
        'as' => 'admin.interns.school.create',
        'uses' => 'SchoolController@create',
        'middleware' => 'can:interns.schools.create'
    ]);
    $router->post('schools', [
        'as' => 'admin.interns.school.store',
        'uses' => 'SchoolController@store',
        'middleware' => 'can:interns.schools.create'
    ]);
    $router->get('schools/{school}/edit', [
        'as' => 'admin.interns.school.edit',
        'uses' => 'SchoolController@edit',
        'middleware' => 'can:interns.schools.edit'
    ]);
    $router->put('schools/{school}', [
        'as' => 'admin.interns.school.update',
        'uses' => 'SchoolController@update',
        'middleware' => 'can:interns.schools.edit'
    ]);
    $router->delete('schools/{school}', [
        'as' => 'admin.interns.school.destroy',
        'uses' => 'SchoolController@destroy',
        'middleware' => 'can:interns.schools.destroy'
    ]);
    $router->bind('faculty', function ($id) {
        return app('Modules\Interns\Repositories\FacultyRepository')->find($id);
    });
    $router->get('faculties', [
        'as' => 'admin.interns.faculty.index',
        'uses' => 'FacultyController@index',
        'middleware' => 'can:interns.faculties.index'
    ]);
    $router->get('faculties/create', [
        'as' => 'admin.interns.faculty.create',
        'uses' => 'FacultyController@create',
        'middleware' => 'can:interns.faculties.create'
    ]);
    $router->post('faculties', [
        'as' => 'admin.interns.faculty.store',
        'uses' => 'FacultyController@store',
        'middleware' => 'can:interns.faculties.create'
    ]);
    $router->get('faculties/{faculty}/edit', [
        'as' => 'admin.interns.faculty.edit',
        'uses' => 'FacultyController@edit',
        'middleware' => 'can:interns.faculties.edit'
    ]);
    $router->put('faculties/{faculty}', [
        'as' => 'admin.interns.faculty.update',
        'uses' => 'FacultyController@update',
        'middleware' => 'can:interns.faculties.edit'
    ]);
    $router->delete('faculties/{faculty}', [
        'as' => 'admin.interns.faculty.destroy',
        'uses' => 'FacultyController@destroy',
        'middleware' => 'can:interns.faculties.destroy'
    ]);
    $router->bind('student', function ($id) {
        return app('Modules\Interns\Repositories\StudentRepository')->find($id);
    });
    $router->get('students', [
        'as' => 'admin.interns.student.index',
        'uses' => 'StudentController@index',
        'middleware' => 'can:interns.students.index'
    ]);
    $router->get('students/create', [
        'as' => 'admin.interns.student.create',
        'uses' => 'StudentController@create',
        'middleware' => 'can:interns.students.create'
    ]);
    $router->post('students', [
        'as' => 'admin.interns.student.store',
        'uses' => 'StudentController@store',
        'middleware' => 'can:interns.students.create'
    ]);
    $router->get('students/{student}/edit', [
        'as' => 'admin.interns.student.edit',
        'uses' => 'StudentController@edit',
        'middleware' => 'can:interns.students.edit'
    ]);
    $router->put('students/{student}', [
        'as' => 'admin.interns.student.update',
        'uses' => 'StudentController@update',
        'middleware' => 'can:interns.students.edit'
    ]);
    $router->delete('students/{student}', [
        'as' => 'admin.interns.student.destroy',
        'uses' => 'StudentController@destroy',
        'middleware' => 'can:interns.students.destroy'
    ]);
    $router->bind('schedule', function ($id) {
        return app('Modules\Interns\Repositories\ScheduleRepository')->find($id);
    });
    $router->get('schedules', [
        'as' => 'admin.interns.schedule.index',
        'uses' => 'ScheduleController@index',
        'middleware' => 'can:interns.schedules.index'
    ]);
    $router->get('schedules/create', [
        'as' => 'admin.interns.schedule.create',
        'uses' => 'ScheduleController@create',
        'middleware' => 'can:interns.schedules.create'
    ]);
    $router->post('schedules', [
        'as' => 'admin.interns.schedule.store',
        'uses' => 'ScheduleController@store',
        'middleware' => 'can:interns.schedules.create'
    ]);
    $router->get('schedules/{schedule}/edit', [
        'as' => 'admin.interns.schedule.edit',
        'uses' => 'ScheduleController@edit',
        'middleware' => 'can:interns.schedules.edit'
    ]);
    $router->put('schedules/{schedule}', [
        'as' => 'admin.interns.schedule.update',
        'uses' => 'ScheduleController@update',
        'middleware' => 'can:interns.schedules.edit'
    ]);
    $router->delete('schedules/{schedule}', [
        'as' => 'admin.interns.schedule.destroy',
        'uses' => 'ScheduleController@destroy',
        'middleware' => 'can:interns.schedules.destroy'
    ]);
    $router->bind('intern_diary', function ($id) {
        return app('Modules\Interns\Repositories\Intern_DiaryRepository')->find($id);
    });
    $router->get('intern_diaries', [
        'as' => 'admin.interns.intern_diary.index',
        'uses' => 'Intern_DiaryController@index',
        'middleware' => 'can:interns.intern_diaries.index'
    ]);
    $router->get('intern_diaries/create', [
        'as' => 'admin.interns.intern_diary.create',
        'uses' => 'Intern_DiaryController@create',
        'middleware' => 'can:interns.intern_diaries.create'
    ]);
    $router->post('intern_diaries', [
        'as' => 'admin.interns.intern_diary.store',
        'uses' => 'Intern_DiaryController@store',
        'middleware' => 'can:interns.intern_diaries.create'
    ]);
    $router->get('intern_diaries/{intern_diary}/edit', [
        'as' => 'admin.interns.intern_diary.edit',
        'uses' => 'Intern_DiaryController@edit',
        'middleware' => 'can:interns.intern_diaries.edit'
    ]);
    $router->put('intern_diaries/{intern_diary}', [
        'as' => 'admin.interns.intern_diary.update',
        'uses' => 'Intern_DiaryController@update',
        'middleware' => 'can:interns.intern_diaries.edit'
    ]);
    $router->delete('intern_diaries/{intern_diary}', [
        'as' => 'admin.interns.intern_diary.destroy',
        'uses' => 'Intern_DiaryController@destroy',
        'middleware' => 'can:interns.intern_diaries.destroy'
    ]);
    $router->bind('history', function ($id) {
        return app('Modules\Interns\Repositories\HistoryRepository')->find($id);
    });
    $router->get('histories', [
        'as' => 'admin.interns.history.index',
        'uses' => 'HistoryController@index',
        'middleware' => 'can:interns.histories.index'
    ]);
    $router->get('histories/create', [
        'as' => 'admin.interns.history.create',
        'uses' => 'HistoryController@create',
        'middleware' => 'can:interns.histories.create'
    ]);
    $router->post('histories', [
        'as' => 'admin.interns.history.store',
        'uses' => 'HistoryController@store',
        'middleware' => 'can:interns.histories.create'
    ]);
    $router->get('histories/{history}/edit', [
        'as' => 'admin.interns.history.edit',
        'uses' => 'HistoryController@edit',
        'middleware' => 'can:interns.histories.edit'
    ]);
    $router->put('histories/{history}', [
        'as' => 'admin.interns.history.update',
        'uses' => 'HistoryController@update',
        'middleware' => 'can:interns.histories.edit'
    ]);
    $router->delete('histories/{history}', [
        'as' => 'admin.interns.history.destroy',
        'uses' => 'HistoryController@destroy',
        'middleware' => 'can:interns.histories.destroy'
    ]);
    // Fullcalendar Schedule
    $router->post('fullcalendar-ajax', 'ScheduleController@createEvents');
    $router->post('fullcalendar/store', [
        'as' => 'admin.interns.fullcalendar.store',
        'uses' => 'ScheduleController@storeFullcalendar',
    ]);
    
    $router->bind('register', function ($id) {
        return app('Modules\Interns\Repositories\RegisterRepository')->find($id);
    });
    $router->get('registers', [
        'as' => 'admin.interns.register.index',
        'uses' => 'RegisterController@index',
        'middleware' => 'can:interns.registers.index'
    ]);
    $router->get('registers/create', [
        'as' => 'admin.interns.register.create',
        'uses' => 'RegisterController@create',
        'middleware' => 'can:interns.registers.create'
    ]);
    $router->post('registers', [
        'as' => 'admin.interns.register.store',
        'uses' => 'RegisterController@store',
        'middleware' => 'can:interns.registers.create'
    ]);
    $router->get('registers/{register}/edit', [
        'as' => 'admin.interns.register.edit',
        'uses' => 'RegisterController@edit',
        'middleware' => 'can:interns.registers.edit'
    ]);
    $router->put('registers/{register}', [
        'as' => 'admin.interns.register.update',
        'uses' => 'RegisterController@update',
        'middleware' => 'can:interns.registers.edit'
    ]);
    $router->delete('registers/{register}', [
        'as' => 'admin.interns.register.destroy',
        'uses' => 'RegisterController@destroy',
        'middleware' => 'can:interns.registers.destroy'
    ]);
// append







});
