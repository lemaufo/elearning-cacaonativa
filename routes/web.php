<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Editor\CourseController as EditorCourseController;
use App\Http\Controllers\Colaborador\CourseController as ColabCourseController;
use App\Http\Controllers\Colaborador\QuizController as ColabQuizController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Colaborador
Route::middleware(['auth'])->prefix('cursos')->name('cursos.')->group(function () {
    Route::get('/', [ColabCourseController::class, 'index'])->name('index');
    Route::get('/{course}', [ColabCourseController::class, 'show'])->name('show');
    Route::post('/{course}/enroll', [ColabCourseController::class, 'enroll'])->name('enroll');
    Route::post('/{course}/lessons/{lesson}/complete', [ColabCourseController::class, 'completeLesson'])
        ->name('lessons.complete');
    Route::get('/{course}/quiz', [ColabQuizController::class, 'show'])->name('quiz.show');
    Route::post('/{course}/quiz', [ColabQuizController::class, 'submit'])->name('quiz.submit');
    Route::get('/{course}/certificate', [ColabQuizController::class, 'certificate'])->name('certificate');
});

// Editor
Route::middleware(['auth'])->prefix('editor')->name('editor.')->group(function () {
    Route::resource('courses', EditorCourseController::class);
    Route::patch('courses/{course}/submit', [EditorCourseController::class, 'submit'])
        ->name('courses.submit');
});

// Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('courses', AdminCourseController::class);
    Route::patch('courses/{course}/status', [AdminCourseController::class, 'updateStatus'])
        ->name('courses.status');
    Route::resource('courses.quizzes', AdminQuizController::class)->shallow();
    // Preguntas del quiz
    Route::post('quizzes/{quiz}/questions', [AdminQuizController::class, 'storeQuestion'])
        ->name('quizzes.questions.store');
    Route::delete('questions/{question}', [AdminQuizController::class, 'destroyQuestion'])
        ->name('questions.destroy');
    Route::post('quizzes/{quiz}/unlock/{userId}', [AdminQuizController::class, 'unlockAttempt'])
        ->name('quizzes.unlock');
    
        Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->name('dashboard');
Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])
    ->name('reports.index');
Route::get('reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])
    ->name('reports.export');
});

require __DIR__.'/auth.php';