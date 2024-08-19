<?php

use App\Http\Livewire\AddMonitoringactivity;
use App\Http\Livewire\AdminLogCar;
use App\Http\Livewire\AssignedTasks;
use App\Http\Livewire\AssignRole;
use App\Http\Livewire\CarLogs;
use App\Http\Livewire\ClosedCar;
use App\Http\Livewire\FSCNonIdNonconformance;
use App\Http\Livewire\LogCar;
use App\Http\Livewire\MyOwnNonConform;
use App\Http\Livewire\NonIdNonconformance;
use App\Http\Livewire\Response;
use App\Http\Livewire\ResponseFSC;
use App\Http\Livewire\ViewTasks;
use App\Http\Livewire\ViewYearPlan;
use App\Http\Livewire\YearlyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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
    return redirect('/login');
});

Route::get('/test', function () {
    return view('car.logs');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth'])->group(function () {

    Route::middleware(['auditor'])->group(function () {
        Route::middleware(['LA'])->group(function () {
            //AddActivitiesToAudit
            Route::get('/Add-Activities-To-Audit', AddMonitoringactivity::class)->name('addActivity');
            //YearlyPlan
            Route::get('/Yearly-Plan', YearlyPlan::class)->name('yearly.plan');
            //View Tasks
            Route::get('/View-Assigned-Tasks', ViewTasks::class)->name('view.tasks');
            //Assign Follow Up
            Route::get('/Assign-follow-up-Role', AssignRole::class)->name('followup');
        });
        Route::middleware(['HOD'])->group(function () {
            //HOD Response
            Route::get('/Manager-Response/Operations', [App\Http\Controllers\AuditController::class, 'Operations'])->name('OP.response');
            Route::get('/Manager-Response/Forestry', [App\Http\Controllers\AuditController::class, 'Forestry'])->name('FR.response');
            Route::get('/Manager-Response/FSC', [App\Http\Controllers\AuditController::class, 'FSC'])->name('FSC.response');
            Route::get('/Manager-Response/HR', [App\Http\Controllers\AuditController::class, 'HR'])->name('HR.response');
            Route::get('/Manager-Response/IT', [App\Http\Controllers\AuditController::class, 'IT'])->name('IT.response');
            Route::get('/Manager-Response/Communications', [App\Http\Controllers\AuditController::class, 'Communications'])->name('CM.response');
            Route::get('/Manager-Response/Miti_Magazine', [App\Http\Controllers\AuditController::class, 'Miti_Magazine'])->name('MITI.response');
            Route::get('/Manager-Response/Accounts', [App\Http\Controllers\AuditController::class, 'Accounts'])->name('ACC.response');
            Route::get('/Manager-Response/M-E', [App\Http\Controllers\AuditController::class, 'ME'])->name('ME.response');
            Route::get('/Manager-Response/Quality-coordinator', [App\Http\Controllers\AuditController::class, 'QC'])->name('QC.response');

            Route::get('/HOD-Response/Operations', [App\Http\Controllers\DeptApprovalController::class, 'Operations'])->name('OP.approval');
            Route::get('/HOD-Response/Forestry', [App\Http\Controllers\DeptApprovalController::class, 'Forestry'])->name('FR.approval');
            Route::get('/HOD-Response/FSC', [App\Http\Controllers\DeptApprovalController::class, 'FSC'])->name('FSC.approval');
            Route::get('/HOD-Response/HR', [App\Http\Controllers\DeptApprovalController::class, 'HR'])->name('HR.approval');
            Route::get('/HOD-Response/IT', [App\Http\Controllers\DeptApprovalController::class, 'IT'])->name('IT.approval');
            Route::get('/HOD-Response/Communications', [App\Http\Controllers\DeptApprovalController::class, 'Communications'])->name('CM.approval');
            Route::get('/HOD-Response/Miti_Magazine', [App\Http\Controllers\DeptApprovalController::class, 'Miti_Magazine'])->name('MITI.approval');
            Route::get('/HOD-Response/Accounts', [App\Http\Controllers\DeptApprovalController::class, 'Accounts'])->name('ACC.approval');
            Route::get('/HOD-Response/M-E', [App\Http\Controllers\DeptApprovalController::class, 'ME'])->name('ME.approval');
            Route::get('/HOD-Response/Quality-coodinator', [App\Http\Controllers\DeptApprovalController::class, 'QC'])->name('QC.approval');
            //Closed CARs
            Route::view('/closed-CARS', 'car.closed-car')->name('closed.car');
            //Logs
            Route::view('/CAR-Logs', 'car.logs')->name('car.logs');

        //Closed CARs
        Route::view('/closed-CARS', 'car.closed-car')->name('closed.car');
        //Logs
        Route::view('/CAR-Logs', 'car.logs')->name('car.logs');
        //Admin Logs
        Route::view('/admin-CAR-Logs', 'car.admin-logs')->name('admin.car.logs');
        //selected Car logs
        Route::get('/Selected-CAR/{id}', LogCar::class)->name('car.selected');
        //selected Car Admin Log
        Route::get('/admin-selected-CAR/{id}', AdminLogCar::class)->name('admin.car.selected');
        });

        //ViewYearlyPlan
        Route::get('/View-Year-Plan', ViewYearPlan::class)->name('Viewyear.plan');
        //AssignedTask
        Route::get('/My-Tasks', AssignedTasks::class)->name('assigned.Task');
        //Auditee Response
        Route::get('/Auditee-Response', Response::class)->name('auditee.respond');
        // FSC Auditee Response
        Route::get('/FSCAuditee-Response', ResponseFSC::class)->name('fscauditee.respond');


        //Edit Nonconformance
        Route::get('/Edit-Non-Conformance-{id}', [App\Http\Controllers\AuditController::class, 'edit'])->name('edit');
        // Fsc Nonconfomance
        Route::get('/Edit-Non-ConformanceFSC-{id}', [App\Http\Controllers\AuditController::class, 'edit'])->name('edit');
        //Follow Up
        Route::get('/Follow-Up', [App\Http\Controllers\AuditController::class, 'followUp'])->name('follow');
        //Update Nonconformance
        Route::patch('/update-Non-Conformance-{nonConformance}', [App\Http\Controllers\AuditController::class, 'update'])->name('update');
        //Update NonconformanceFSC
        Route::patch('/update-Non-ConformanceFSC-{nonConformanceFSC}', [App\Http\Controllers\AuditController::class, 'update'])->name('update');
        //Post Checklist
        Route::get('/Task-Response', [App\Http\Controllers\AuditController::class, 'taskresponse'])->name('task.response');
        //New Nonconformance
        Route::get('/PrepareNew-Non-Conformance-{id}', [App\Http\Controllers\AuditController::class, 'nonconformance'])->name('new.audit');
        //New NonconformanceFSC
        Route::get('/PrepareNew-Non-ConformanceFSC-{id}', [App\Http\Controllers\AuditController::class, 'nonconformanceFSC'])->name('new.audit');


        //Edit Nonconformance
        Route::get('/Edit-Non-Conformance-{id}', [App\Http\Controllers\AuditController::class, 'edit'])->name('edit');
        // Fsc Nonconfomance
        Route::get('/Edit-Non-ConformanceFSC-{id}', [App\Http\Controllers\AuditController::class, 'edit'])->name('edit');
   });
    //MY Non-conformances
    Route::get('/Home', MyOwnNonConform::class)->name('home');
    //Non-Conformance file
    Route::get('/View/{id}/file', [App\Http\Controllers\AuditController::class, 'file'])->name('view.file');
    //Follow file
    Route::get('/View/{id}/image', [App\Http\Controllers\AuditController::class, 'image'])->name('view.image');
    //NonId Nonconformance
    Route::get('/Non-confomance-NonID', NonIdNonconformance::class)->name('non.IDconform');
    //Nonid NonconfomanceFSC
    Route::get('/Non-confomance-FSCID', FSCNonIdNonconformance::class)->name('non.IDconformFSC');
   

});

Route::post('/file-upload', [App\Http\Controllers\AuditController::class, 'fileUpload']);

require __DIR__ . '/auth.php';
