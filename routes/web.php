<?php
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\SupervisorApprovalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::resource('programs',ProgramController::class);
Route::resource('departments',DepartmentController::class);
Route::resource('positions',PositionController::class);




Route::post('/requisitions/{requisition}/approveProcurement', [SupervisorApprovalController::class, 'approveProcurement'])->name('requisitions.approveProcurement');
Route::post('/requisitions/{requisition}/rejectProcurement', [SupervisorApprovalController::class, 'rejectProcurement'])->name('requisitions.rejectProcurement');
Route::post('/requisitions/{requisition}/approveFinance', [SupervisorApprovalController::class, 'approveFinance'])->name('requisitions.approveFinance');
Route::post('/requisitions/{requisition}/rejectFinance', [SupervisorApprovalController::class, 'rejectFinance'])->name('requisitions.rejectFinance');
Route::get('/approvals/{approval}',[SupervisorApprovalController::class,'track'])->name('approvals.track');









Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*----------------- <Programs------------>*/





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    

    Route::resource('requisitions',RequisitionController::class);
    Route::post('/requisitions/{requisition}/approve', [SupervisorApprovalController::class, 'approve']);
    Route::post('/requisitions/{requisition}/reject', [SupervisorApprovalController::class, 'reject']);
    // routes/web.php
Route::get('/requisitions/{requisition}/track', [RequisitionController::class, 'track'])
->name('requisitions.track');

Route::get('/reports/status-summary', [ReportController::class, 'statusSummary'])->name('reports.status');
Route::get('/reports', [ReportController::class, 'reports'])->name('reports');



Route::middleware(['auth', 'verified'])->prefix('/reports')->name('reports.')->group(function () {
    Route::get('/today', [ReportController::class, 'today'])->name('today');
    Route::get('/this-week', [ReportController::class, 'thisWeek'])->name('this-week');
    Route::get('/this-month', [ReportController::class, 'thisMonth'])->name('this-month');
    Route::get('/this-year', [ReportController::class, 'thisYear'])->name('this-year');
});

Route::middleware(['auth', 'verified'])->prefix('/reports/department')->name('reports.department')->group(function () {
    Route::get('/today', [ReportController::class, 'today'])->name('today');
    Route::get('/this-week', [ReportController::class, 'thisWeek'])->name('this-week');
    Route::get('/this-month', [ReportController::class, 'thisMonth'])->name('this-month');
    Route::get('/this-year', [ReportController::class, 'thisYear'])->name('this-year');
});

});




require __DIR__.'/auth.php';


