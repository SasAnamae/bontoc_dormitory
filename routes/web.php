<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Student\TermsController;
use App\Http\Controllers\Student\OccupantProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Student\ReservationController as StudentReservationController;
use App\Http\Controllers\Admin\StudentInfoController;
use App\Http\Controllers\Student\DormitoryController;
use App\Http\Controllers\Student\RoomController;
use App\Http\Controllers\Student\DormitoryAgreementController;
use App\Http\Controllers\Student\StudentFormsController;
use App\Http\Controllers\Cashier\PaymentController;



    // Landing Page
    Route::get('/', function () {
        return view('welcome');
    });
    // Show Login Form
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // DASHBOARD REDIRECT AFTER LOGIN
    Route::get('/dashboard', function () {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'student') {
                return redirect()->route('student.dashboard');
            }
        }
        return redirect('/');
    })->middleware('auth')->name('dashboard');

    // ==================== ADMIN ROUTES ==================== //
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('dormitories', App\Http\Controllers\Admin\DormitoryController::class);
        Route::resource('rooms', App\Http\Controllers\Admin\RoomController::class);
        Route::get('/student-info', [App\Http\Controllers\Admin\StudentInfoController::class, 'index'])
        ->name('student_info.index');

        Route::delete('/reservations/{id}', [App\Http\Controllers\Admin\ReservationController::class, 'destroy'])->name('reservations.destroy');
        Route::get('/reservations', [App\Http\Controllers\Admin\ReservationController::class, 'index'])->name('reservations.index');
        Route::patch('/reservations/{reservation}/status/{status}', [App\Http\Controllers\Admin\ReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
        Route::delete('/reservations/{reservation}', [App\Http\Controllers\Admin\ReservationController::class, 'destroy'])->name('reservations.destroy');
        
        Route::get('/applications', [App\Http\Controllers\Admin\ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{id}', [App\Http\Controllers\Admin\ApplicationController::class, 'show'])
    ->name('applications.show');
        Route::delete('/applications/{id}', [App\Http\Controllers\Admin\ApplicationController::class, 'destroy'])->name('applications.destroy');
        Route::post('/applications/{id}/approve', [App\Http\Controllers\Admin\ApplicationController::class, 'approve'])->name('applications.approve');
        Route::post('/applications/{id}/reject', [App\Http\Controllers\Admin\ApplicationController::class, 'reject'])->name('applications.reject');
        

        Route::get('/payments/export', [App\Http\Controllers\Admin\PaymentController::class, 'export'])->name('payments.export');
        Route::get('/payments/logs/export', [App\Http\Controllers\Admin\PaymentController::class, 'exportLogs'])->name('payments.logs.export');
        Route::get('/payments/logs', [App\Http\Controllers\Admin\PaymentController::class, 'logs'])
        ->name('payments.logs');
        Route::resource('payments', App\Http\Controllers\Admin\PaymentController::class);
        Route::delete('/payments/{schedule}/student/{student}', [PaymentController::class, 'destroyStudentPayment'])
    ->name('admin.payments.destroyStudent');
    });

  

    // ==================== STUDENT ROUTES ==================== //
    Route::middleware(['auth', 'role:student', 'check.terms'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/terms', [App\Http\Controllers\StudentController::class, 'showTerms'])->name('terms');
        Route::post('/terms/agree', [App\Http\Controllers\StudentController::class, 'agreeTerms'])->name('terms.agree');

        
        Route::get('/dorm/{dorm}', [App\Http\Controllers\Student\DormitoryController::class, 'show'])->name('dorm.show');
        Route::get('/room/{room}', [App\Http\Controllers\Student\RoomController::class, 'show'])->name('room.show');
        Route::post('/reserve/{bed}', [StudentReservationController::class, 'store'])->name('reserve.bed');
        Route::get('/reservations', [App\Http\Controllers\Student\ReservationController::class, 'index'])->name('reservations');
        Route::post('/reservations', [App\Http\Controllers\Student\ReservationController::class, 'store'])->name('reservations.store');
        Route::delete('/reservations/{id}', [App\Http\Controllers\Student\ReservationController::class, 'destroy'])->name('reservations.destroy');

        Route::resource('profile', OccupantProfileController::class)->except(['index', 'show', 'destroy']);
        Route::resource('agreement', DormitoryAgreementController::class)->except(['index', 'show', 'destroy']);
        Route::get('/profile/create', [OccupantProfileController::class, 'create'])->name('profile.create');
        Route::post('/profile', [OccupantProfileController::class, 'store'])->name('profile.store');
        Route::get('/profile/{profile}/edit', [OccupantProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/{profile}', [OccupantProfileController::class, 'update'])->name('profile.update');
        Route::get('/forms/summary', [StudentFormsController::class, 'summary'])->name('forms.summary');
        Route::post('/forms/finalize', [StudentFormsController::class, 'finalize'])->name('forms.finalize');

        Route::get('/payments', [App\Http\Controllers\Student\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/download', [App\Http\Controllers\Student\PaymentController::class, 'download'])->name('payments.download');

    });

    Route::middleware(['auth'])->group(function () {
        Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::delete('/notifications', [App\Http\Controllers\NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
        Route::get('/notifications/read/{id}', function($id) {
            $notification = auth()->user()->notifications()->findOrFail($id);
            $notification->markAsRead();
            return redirect()->to($notification->data['url'] ?? url()->previous());
        })->name('notifications.read');
    });


    Route::middleware(['auth', 'role:cashier'])->prefix('cashier')->name('cashier.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Cashier\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/occupants', [App\Http\Controllers\Cashier\OccupantController::class, 'index'])->name('occupants.index');
        Route::get('/occupants/download', [App\Http\Controllers\Cashier\OccupantController::class, 'download'])->name('occupants.download');
        Route::get('/occupants/export', [App\Http\Controllers\Cashier\OccupantController::class, 'export'])->name('occupants.export');
        Route::resource('payments', App\Http\Controllers\Cashier\PaymentController::class)->except(['show']);;
        Route::get('payments/download', [App\Http\Controllers\Cashier\PaymentController::class, 'download'])
        ->name('payments.download');
    });

