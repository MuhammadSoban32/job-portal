<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\JobController as AdminJobContrpller;
use App\Http\Controllers\admin\JobApplicationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/jobs',[JobController::class,'index'])->name('jobs');
Route::get('/jobs/detail/{id}',[JobController::class,'detail'])->name('jobDetail');
Route::post('/apply-job',[JobController::class,'applyJob'])->name('applyJob');
Route::post('/save-job',[JobController::class,'saveJob'])->name('saveJob');


Route::get('/forgot-password',[AccountController::class,'forgotPassword'])->name('account.forgot-password');
Route::post('/forgot-password-process',[AccountController::class,'processForgotPassword'])->name('account.forgot-password-process');
Route::get('/reset-password/{token}',[AccountController::class,'resetPassword'])->name('account.resetPassword');
Route::post('/process-reset-password',[AccountController::class,'processResetPassword'])->name('account.processResetPassword');

Route::group(['prefix' => 'admin', 'middleware' => 'checkRole'],function(){

    Route::get('dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
    
    Route::get('users',[UserController::class,'index'])->name('admin.users');               
    Route::get('users/edit/{id}',[UserController::class,'edit'])->name('admin.users.edit');
    Route::put('user/update/{id}',[UserController::class,'update'])->name('admin.user.update');
    Route::post('user/destroy',[UserController::class,'destroy'])->name('admin.user.destroy');
    Route::get('jobs',[AdminJobContrpller::class,'index'])->name('admin.jobs');
    Route::get('jobs/edit/{id}',[AdminJobContrpller::class,'edit'])->name('admin.job.edit');
    Route::put('jobs/update/{id}',[AdminJobContrpller::class,'update'])->name('admin.job.update');
    Route::delete('jobs/destroy',[AdminJobContrpller::class,'destroy'])->name('admin.job.delete');
    
    Route::get('jobs-applications',[JobApplicationController::class,'index'])->name('admin.job.applications');
    Route::delete('jobs-applications/delete',[JobApplicationController::class,'destroy'])->name('admin.jobApplications.delete');
 

});

Route::group(['prefix' => 'account'],function(){

    // Guest Routes
    Route::group(['middleware' => 'guest'],function(){
        Route::get('register',[AccountController::class,'registration'])->name('account.registration');
        Route::post('process-register',[AccountController::class,'processRegistration'])->name('account.processRegistration');
        Route::get('login',[AccountController::class,'login'])->name('account.login');
        Route::post('authenticate',[AccountController::class,'authenticate'])->name('account.authenticate');
    });
    
    // Authenticated Routes
    Route::group(['middleware' => 'auth'],function(){
        Route::get('profile',[AccountController::class,'profile'])->name('account.profile');
        Route::put('update-profile',[AccountController::class,'updateProfile'])->name('account.updateProfile');
        Route::post('update-profile-pic',[AccountController::class,'updateProfilePic'])->name('account.updateProfilePic');
        Route::put('update-password',[AccountController::class,'updatePassword'])->name('account.updatePassword');
        Route::get('logout',[AccountController::class,'logout'])->name('account.logout');
        
        // Jobs
        Route::get('create-job',[AccountController::class,'createJob'])->name('account.createJob');
        Route::post('save-job',[AccountController::class,'saveJob'])->name('account.saveJob');
        Route::get('my-job',[AccountController::class,'myJob'])->name('account.myJob');
        Route::get('my-job/edit/{jobId}',[AccountController::class,'editJob'])->name('account.editJob');
        Route::post('my-job/update/{jobId}',[AccountController::class,'updateJob'])->name('account.updateJob');
        Route::post('my-job/deleteJob',[AccountController::class,'deleteJob'])->name('account.deleteJob');
        Route::get('/my-job-applications',[AccountController::class,'myJobApplication'])->name('account.myJobApplication');
        
        Route::post('/remove-job-application',[AccountController::class,'removeJobs'])->name('account.removeJobs');
        Route::get('/saved-job',[AccountController::class,'savedJobs'])->name('account.savedJobs');
        Route::post('/remove-saved-job',[AccountController::class,'removeSavedJobs'])->name('account.removeSavedJob');


    });
});