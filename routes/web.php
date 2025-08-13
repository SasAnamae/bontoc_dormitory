<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Student\TermsController;
use App\Http\Controllers\Student\OccupantProfileController as OccupantProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Student\ReservationController as StudentReservationController;
use App\Http\Controllers\Admin\StudentInfoController;
use App\Http\Controllers\Student\DormitoryController;
use App\Http\Controllers\Student\RoomController;
use App\Http\Controllers\Student\DormitoryAgreementController;
use App\Http\Controllers\Student\StudentFormsController;
use App\Http\Controllers\Admin\OccupantProfileController as AdminOccupantProfileController;
use App\Http\Controllers\Student\StudentReportController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Student\ApplicationFormController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Admin\PaymentControllerr;
use App\Models\Payment;
use App\Models\Announcement;

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
    

    Route::get('/notifications/unread-count', function () {
    return response()->json([
        'count' => auth()->user()->unreadNotifications()->count()
    ]);
})->middleware('auth')->name('notifications.count');
    Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');



    // ==================== ADMIN ROUTES ==================== //
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('dormitories', App\Http\Controllers\Admin\DormitoryController::class);
        Route::resource('rooms', App\Http\Controllers\Admin\RoomController::class);
        Route::get('/profile/{profile}/edit', [AdminOccupantProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/{profile}', [AdminOccupantProfileController::class, 'update'])->name('profile.update');
        Route::get('/student-info', [App\Http\Controllers\Admin\StudentInfoController::class, 'index'])
        ->name('student_info.index');

        Route::delete('/reservations/{id}', [App\Http\Controllers\Admin\ReservationController::class, 'destroy'])->name('reservations.destroy');
        Route::get('/reservations', [App\Http\Controllers\Admin\ReservationController::class, 'index'])->name('reservations.index');
        Route::patch('/reservations/{reservation}/status/{status}', [App\Http\Controllers\Admin\ReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
        Route::delete('/reservations/{reservation}', [App\Http\Controllers\Admin\ReservationController::class, 'destroy'])->name('reservations.destroy');
        
        Route::get('/applications', [App\Http\Controllers\Admin\ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{user}', [App\Http\Controllers\Admin\ApplicationController::class, 'show'])
    ->name('applications.show');
        Route::delete('/applications/{id}', [App\Http\Controllers\Admin\ApplicationController::class, 'destroy'])->name('applications.destroy');
        Route::post('/applications/{id}/approve', [App\Http\Controllers\Admin\ApplicationController::class, 'approve'])->name('applications.approve');
        Route::post('/applications/{id}/reject', [App\Http\Controllers\Admin\ApplicationController::class, 'reject'])->name('applications.reject');
      
        Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments/{payment}/verify', [App\Http\Controllers\Admin\PaymentController::class, 'verify'])->name('payments.verify');
        Route::post('/payments/{payment}/reject', [App\Http\Controllers\Admin\PaymentController::class, 'reject'])->name('payments.reject');
        Route::get('/payments/export', [App\Http\Controllers\Admin\PaymentController::class, 'export'])->name('payments.export');
        Route::get('/payments/logs/export', [App\Http\Controllers\Admin\PaymentController::class, 'exportLogs'])->name('payments.logs.export');
        Route::get('/payments/logs', [App\Http\Controllers\Admin\PaymentController::class, 'logs'])
        ->name('payments.logs');
        Route::resource('payments', App\Http\Controllers\Admin\PaymentController::class);
        Route::delete('/payments/{schedule}/student/{student}', [PaymentController::class, 'destroyStudentPayment'])
    ->name('admin.payments.destroyStudent');

    
        Route::get('/reports', [App\Http\Controllers\Admin\StudentReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [App\Http\Controllers\Admin\StudentReportController::class, 'show'])->name('reports.show');
        Route::put('/reports/{report}', [App\Http\Controllers\Admin\StudentReportController::class, 'update'])->name('reports.update');
        Route::delete('/reports/{report}', [App\Http\Controllers\Admin\StudentReportController::class, 'destroy'])->name('reports.destroy');
        

        Route::get('/announcements', [App\Http\Controllers\Admin\AnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create', [App\Http\Controllers\Admin\AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [App\Http\Controllers\Admin\AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{announcement}', [App\Http\Controllers\Admin\AnnouncementController::class, 'show'])->name('announcements.show');
        Route::delete('/announcements/{announcement}', [App\Http\Controllers\Admin\AnnouncementController::class, 'destroy'])->name('announcements.destroy');
});

  

    // ==================== STUDENT ROUTES ==================== //
    Route::middleware(['auth', 'role:student', 'check.terms'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
        Route::delete('/{id}/reset-progress', [App\Http\Controllers\Student\DashboardController::class, 'resetProgress'])
    ->name('reset.progress');

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
    
        Route::get('/payments', [App\Http\Controllers\Student\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/create', [App\Http\Controllers\Student\PaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments', [App\Http\Controllers\Student\PaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/{payment}', [App\Http\Controllers\Student\PaymentController::class, 'show'])->name('payments.show');
        Route::get('/payments/download', [App\Http\Controllers\Student\PaymentController::class, 'download'])->name('payments.download');

        Route::get('report', [StudentReportController::class, 'index'])->name('report.index');
        Route::get('report/create', [StudentReportController::class, 'create'])->name('report.create');
        Route::get('report/{report}', [StudentReportController::class, 'show'])->name('report.show');
        Route::post('report', [StudentReportController::class, 'store'])->name('report.store');
        Route::delete('report/{report}', [StudentReportController::class, 'destroy'])->name('report.destroy');

        // Application Form Routes (step before profile)
        Route::get('/application', [ApplicationFormController::class, 'show'])->name('application.form');
        Route::post('/application', [ApplicationFormController::class, 'store'])->name('application.store');
        Route::get('/application/view', [ApplicationFormController::class, 'view'])->name('student.application.view');
    });


    Route::middleware(['auth'])->group(function () {
        // Delete single notification (works for both UUIDs and numeric IDs)
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
            ->where('id', '[0-9a-fA-F\-]+')
            ->name('notifications.destroy');

        // Delete all notifications for the authenticated user
        Route::delete('/notifications', [NotificationController::class, 'destroyAll'])
            ->name('notifications.destroyAll');

        // Read and redirect for default notification types (GET)
        Route::get('/notifications/read/{id}', function($id) {
            $notification = auth()->user()->notifications()->findOrFail($id);
            $notification->markAsRead();

            return redirect()->to($notification->data['url'] ?? url()->previous());
        })->where('id', '[0-9a-fA-F\-]+')->name('notifications.read');
    });

    // Announcement Routes

    Route::get('/announcements/{announcement}', function ($id) {
        $announcement = Announcement::findOrFail($id);
        return view('audience.show', compact('announcement'));
    })->name('audience.show');
