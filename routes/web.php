<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/login2', function (Request $request) {
    // dd($request->all());
    session_start();
    $user = DB::table('user')->get();
    foreach ($user as $key => $u) {
        if ($request->username == $u->username && $request->password == $u->password) {
            $_SESSION['id_user'] = $u->id_user;
            $_SESSION['username'] = $request->username;
            $_SESSION['email'] = (DB::table('user')->where('username',$request->username)->first())->email;
            $_SESSION['role'] = (DB::table('user')->where('username',$request->username)->first())->role;
            $_SESSION['position'] = (DB::table('user')->where('username',$request->username)->first())->position;
            $_SESSION['is_block'] = $u->is_block;
            
            return redirect()->route('home')->with('success', 'ยินดีต้อนรับเข้าสู่ระบบ');
        } 
    }
    return redirect()->route('login')->with('danger', 'Username หรือ Password ผิดกรุณาลองใหม่อีกครั้ง');
})->name('login2');

Route::get('/logout', function () {
    session_start();
    session_destroy();
    // dd($_SESSION);
    if (isset($_SESSION['username'])) {
        return redirect()->route('login');
    }
})->name('logout');

Route::middleware('chklogin')->group(function () {

    Route::get('/', function () {
        // dd($_SESSION);
        $menu = DB::table('menu')->get();
        // dd($menu);
        return view('home', compact('menu'));
    })->name('home');

    // task
    route::get('/project_list', 'App\Http\Controllers\TaskController@project_list')->name('project_list');
    route::post('/insert_project', 'App\Http\Controllers\TaskController@insert_project')->name('insert_project');
    route::post('/update_project/{id}', 'App\Http\Controllers\TaskController@update_project')->name('update_project');
    route::get('/remove_project/{id}', 'App\Http\Controllers\TaskController@remove_project')->name('remove_project');

    route::get('/task_list/{id_project}', 'App\Http\Controllers\TaskController@task_list')->name('task_list');
    route::get('/task_detail/{id_task}', 'App\Http\Controllers\TaskController@task_detail')->name('task_detail');
    route::post('/task_detail/insert_checklist', 'App\Http\Controllers\TaskController@insert_checklist')->name('insert_checklist');
    route::get('/task_detail/update_checklist/{id_task}/{id}/{value}', 'App\Http\Controllers\TaskController@update_checklist')->name('update_checklist');
    route::get('/task_detail/remove_checklist/{id_task}/{id}', 'App\Http\Controllers\TaskController@remove_checklist')->name('remove_checklist');
    route::post('/mytasks/add', 'App\Http\Controllers\TaskController@add_tasks')->name('add_tasks');
    route::get('/mytasks/move/{id}/{status}/{bottomId}', 'App\Http\Controllers\TaskController@move_tasks')->name('move_tasks');
    route::post('/mytasks/update/{id}', 'App\Http\Controllers\TaskController@update_tasks')->name('update_tasks');
    route::get('/mytasks/remove/{id}', 'App\Http\Controllers\TaskController@remove_tasks')->name('remove_tasks');

    route::get('/remove_task_file/{id}', 'App\Http\Controllers\TaskController@remove_task_file')->name('remove_task_file');

    // user
    route::get('/user_list', 'App\Http\Controllers\UserController@user_list')->name('user_list');
    route::post('/insert_user', 'App\Http\Controllers\UserController@insert_user')->name('insert_user');
    Route::post('/update_user/{id}', 'App\Http\Controllers\UserController@update_user')->name('update_user');
    Route::get('/rm_user/{id}', 'App\Http\Controllers\UserController@rm_user')->name('rm_user');

    // dashboard
    route::get('/dashboard_index', 'App\Http\Controllers\DashboardController@dashboard_index')->name('dashboard_index');

    // meet
    route::get('/meet_list', 'App\Http\Controllers\MeetController@meet_list')->name('meet_list');
    route::post('/insert_meeting', 'App\Http\Controllers\MeetController@insert_meeting')->name('insert_meeting');
    route::post('/update_meeting/{id}', 'App\Http\Controllers\MeetController@update_meeting')->name('update_meeting');

    // profile
    
    route::get('/edit_profile', 'App\Http\Controllers\UserController@edit_profile')->name('edit_profile');
});
