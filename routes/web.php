<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\authController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {return view('login');
})->name('login');
Route::post('/',[authController::class,'login']);

Route::post('/logout', [authController::class, 'logout'])->name('logout');

    

Route::get('/user_dashboard', [TaskController::class, 'index'])->name('dashboard');
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('update.task.status');
Route::post('/tasks/{task}/comments', [TaskController::class, 'addComment'])->name('add.comment');


Route::get('/admin', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
Route::post('/admin/projects', [AdminController::class, 'storeProject'])->name('admin.projects.store');
Route::post('/admin/tasks', [AdminController::class, 'storeTask'])->name('admin.tasks.store');

Route::group(['prefix' => 'admin'], function () {
    // User routes
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    
    // Project routes
    Route::put('/projects/{id}', [AdminController::class, 'updateProject'])->name('admin.projects.update');
    Route::delete('/projects/{id}', [AdminController::class, 'deleteProject'])->name('admin.projects.delete');
    
    // Task routes
    Route::put('/tasks/{id}', [AdminController::class, 'updateTask'])->name('admin.tasks.update');
    Route::delete('/tasks/{id}', [AdminController::class, 'deleteTask'])->name('admin.tasks.delete');
});