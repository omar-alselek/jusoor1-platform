<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Social\FeedController;
use App\Http\Controllers\Social\PostController;
use App\Http\Controllers\Social\FriendController;
use Illuminate\Support\Facades\Auth;

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

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Projects routes
Route::resource('projects', ProjectController::class);

// Auth routes
// مسارات التسجيل وتسجيل الدخول
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Social Network Routes
Route::middleware(['auth'])->prefix('social')->name('social.')->group(function () {
    // Feed routes
    Route::get('/feed', [FeedController::class, 'index'])->name('feed');
    Route::get('/feed/filter', [FeedController::class, 'filter'])->name('feed.filter');
    
    // Post routes
    Route::resource('posts', PostController::class);
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    Route::put('/comments/{comment}', [PostController::class, 'updateComment'])->name('comments.update');
    Route::delete('/comments/{comment}', [PostController::class, 'deleteComment'])->name('comments.delete');
    
    // Friend routes
    Route::get('/friends', [FriendController::class, 'index'])->name('friends');
    Route::get('/friends/suggestions', [FriendController::class, 'suggestions'])->name('friends.suggestions');
    Route::post('/friends/request/{user}', [FriendController::class, 'sendRequest'])->name('friends.request');
    Route::post('/friends/accept/{user}', [FriendController::class, 'acceptRequest'])->name('friends.accept');
    Route::post('/friends/reject/{user}', [FriendController::class, 'rejectRequest'])->name('friends.reject');
    Route::delete('/friends/remove/{user}', [FriendController::class, 'removeFriend'])->name('friends.remove');
    
    // User search
    Route::get('/search/users', [FriendController::class, 'search'])->name('search.users');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::resource('profile', ProfileController::class)->except(['create', 'store']);
    
    // تغيير كلمة المرور
    Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
    
    // Donation routes
    Route::resource('donations', DonationController::class);
    
    // Volunteer routes
    Route::get('projects/{project}/volunteer', [ProjectController::class, 'volunteerForm'])->name('projects.volunteer.form');
    Route::post('projects/{project}/volunteer', [ProjectController::class, 'volunteer'])->name('projects.volunteer');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/users', [HomeController::class, 'adminUsers'])->name('admin.users');
    Route::get('/projects', [HomeController::class, 'adminProjects'])->name('admin.projects');
    Route::get('/donations', [HomeController::class, 'adminDonations'])->name('admin.donations');
    Route::get('/volunteers', [HomeController::class, 'adminVolunteers'])->name('admin.volunteers');
});

// قسم مدير المشروع
Route::middleware(['auth', 'role:moderator'])->prefix('project-manager')->name('project-manager.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\ProjectManager\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/projects', [App\Http\Controllers\ProjectManager\DashboardController::class, 'projects'])->name('projects');
    Route::get('/donations', [App\Http\Controllers\ProjectManager\DashboardController::class, 'donations'])->name('donations');
    
    // مسارات إدارة المتطوعين
    Route::get('/volunteers', [App\Http\Controllers\ProjectManager\DashboardController::class, 'volunteers'])->name('volunteers');
    Route::get('/volunteers/{volunteer}', [App\Http\Controllers\ProjectManager\DashboardController::class, 'showVolunteer'])->name('volunteers.show');
    Route::post('/volunteers/{volunteer}/approve', [App\Http\Controllers\ProjectManager\DashboardController::class, 'approveVolunteer'])->name('volunteers.approve');
    Route::post('/volunteers/{volunteer}/reject', [App\Http\Controllers\ProjectManager\DashboardController::class, 'rejectVolunteer'])->name('volunteers.reject');
});
