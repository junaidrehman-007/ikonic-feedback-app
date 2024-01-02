<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

Route::group(['middleware' => ['auth', 'admin']], function () {


  Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
  //Feedback
  Route::get('feedback/list', [AdminController::class, 'feedback_list'])->name('feedback.list');
  Route::get('feedback/create/{id}', [AdminController::class, 'feedback_create'])->name('feedback.create');
  Route::post('Admin/feedback/submit/{id}', [AdminController::class, 'feedback_submit'])->name('admin.feedback.submit');
  Route::post('feedback/detail', [AdminController::class, 'feedback_detail'])->name('feedback.detail');
  Route::post('feedback/destroy', [AdminController::class, 'feedback_destroy'])->name('feedback.destroy');
  Route::get('/feedback/update/status/{feedbackId}/{status}',  [AdminController::class, 'feedback_update_status'])->name('feedback.update.status');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/login', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// frontend
Route::group(['middleware' => ['auth', 'user']], function () {

  Route::get('/profile', [FrontEndController::class, 'profile'])->name('profile');
  Route::post('/update/profile', [FrontEndController::class, 'update_profile'])->name('update.profile');
  Route::post('/change-password', [FrontEndController::class, 'update_password'])->name('password.update');

  Route::get('/feedback/{filter?}', [FrontEndController::class, 'feedback_filter'])->name('feedback.filter');
  Route::post('feedback/submit', [FrontEndController::class, 'feedback_submit'])->name('feedback.submit');

  Route::post('/vote', [FrontEndController::class, 'vote']);
  Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

  Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');


  Route::get('/notifications/{notification}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
  Route::get('/unread-notifications', [NotificationController::class, 'unreadNotifications'])->name('notifications.unread');




});

Route::get('feedback/form/new', [FrontEndController::class, 'feedback_form'])->name('feedback.form.new');
Route::get('/', [FrontEndController::class, 'all_feed_back'])->name('all.feedback');
