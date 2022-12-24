<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('create-task', [App\Http\Controllers\TaskController::class, 'createTaskForm'])->name('task.form');
    Route::post('create-task', [App\Http\Controllers\TaskController::class, 'createTaskFormSubmit'])->name('task.form.post');

    Route::get('tasks', [App\Http\Controllers\TaskController::class, 'tasks'])->name('tasks');
    Route::get('delete-task', [App\Http\Controllers\TaskController::class, 'delete'])->name('task.delete');
    Route::post('tasks-reorder', [App\Http\Controllers\TaskController::class, 'reorder'])->name('tasks.reorder');

    Route::get('create-project', [App\Http\Controllers\ProjectController::class, 'createProjectForm'])->name('project.form');
    Route::post('create-project', [App\Http\Controllers\ProjectController::class, 'createProjectFormSubmit'])->name('project.form.post');

    Route::get('projects', [App\Http\Controllers\ProjectController::class, 'projects'])->name('projects');
    Route::get('delete-project', [App\Http\Controllers\ProjectController::class, 'delete'])->name('project.delete');

    Route::get('users', [App\Http\Controllers\UserController::class, 'users'])->name('users');
});