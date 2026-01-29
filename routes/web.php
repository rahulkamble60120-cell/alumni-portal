<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicSiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChapterController; 
use App\Http\Controllers\NewsController;
use App\Http\Controllers\GalleryController; 
use App\Http\Controllers\MentorshipController;

// ==========================================
// PUBLIC ROUTES (No Login Required)
// ==========================================

// ✅ ADDED: Redirect Root URL to School Page
Route::get('/', function () {
    return redirect('/school/1');
});

// 1. Institution Home Page
Route::get('/school/{id}', [PublicSiteController::class, 'index']);

// 2. Registration Routes
Route::get('/school/{id}/register', [RegisterController::class, 'showRegistrationForm']);
Route::post('/school/{id}/register', [RegisterController::class, 'register']);

// 3. Login Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// PROTECTED ROUTES (Login Required)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // --- ADMIN ROUTES ---
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Manage Staff
    Route::get('/admin/staff', [AdminController::class, 'staff']);
    Route::post('/admin/staff', [AdminController::class, 'createStaff']);
    Route::get('/admin/staff/{id}/remove', [AdminController::class, 'removeStaff']);

    // Manage Departments
    Route::get('/admin/departments', [DepartmentController::class, 'index']);
    Route::post('/admin/departments', [DepartmentController::class, 'store']);
    Route::get('/admin/departments/{id}/delete', [DepartmentController::class, 'destroy']); 

    // Manage Chapters
    Route::get('/admin/chapters', [ChapterController::class, 'index']);
    Route::post('/admin/chapters', [ChapterController::class, 'store']);
    Route::get('/admin/chapters/{id}/delete', [ChapterController::class, 'destroy']);

    // Manage News 
    Route::get('/admin/news', [NewsController::class, 'index']);
    Route::post('/admin/news', [NewsController::class, 'store']);
    Route::get('/admin/news/{id}/delete', [NewsController::class, 'destroy']);

    // Manage Gallery
    Route::get('/admin/gallery', [GalleryController::class, 'index']);
    Route::post('/admin/gallery', [GalleryController::class, 'store']);
    Route::get('/admin/gallery/{id}/delete', [GalleryController::class, 'destroy']);

    // Manage Alumni
    Route::get('/admin/alumni', [AlumniController::class, 'index']);          
    Route::post('/admin/alumni', [AlumniController::class, 'store']);         
    Route::get('/admin/alumni/{id}/delete', [AlumniController::class, 'destroy']); 
    Route::get('/admin/alumni/{id}/approve', [AlumniController::class, 'approve']); 
    Route::get('/admin/alumni/{id}/reject', [AlumniController::class, 'reject']);   

    // Manage Events
    Route::get('/admin/events', [EventController::class, 'index']);
    Route::post('/admin/events', [EventController::class, 'store']);

    // Manage Jobs
    Route::get('/admin/jobs', [JobController::class, 'index']);
    Route::post('/admin/jobs', [JobController::class, 'store']);
    Route::get('/admin/jobs/{id}/applicants', [JobController::class, 'showApplicants'])->name('admin.applicants');
    Route::get('/admin/application/{id}/{status}', [JobController::class, 'updateStatus'])->name('admin.application.status');

    // Directory
    Route::get('/directory', [DirectoryController::class, 'index']);

    // --- STUDENT ROUTES ---
    Route::get('/student/dashboard', [StudentController::class, 'dashboard']);
    Route::post('/student/profile', [StudentController::class, 'updateProfile']);
    Route::get('/student/gallery', [StudentController::class, 'gallery']);
    
    // Events (RSVP)
    Route::get('/student/events', [StudentController::class, 'events']);
    Route::post('/student/events/{id}/rsvp', [StudentController::class, 'toggleAttendance']);

    // Jobs (Apply)
    Route::get('/student/jobs', [StudentController::class, 'jobs'])->name('jobs.index');
    Route::post('/student/jobs/{id}/apply', [StudentController::class, 'applyJob'])->name('jobs.apply');

    // --- MENTORSHIP ROUTES ---
    Route::get('/student/mentors', [MentorshipController::class, 'index']);
    Route::post('/student/mentors', [MentorshipController::class, 'store']);

    // Alumni Requests
    Route::get('/alumni/requests', [MentorshipController::class, 'myRequests']);
    Route::get('/alumni/request/{id}/{status}', [MentorshipController::class, 'updateStatus']);

    // Route for deleting a job
Route::get('/admin/jobs/{id}/delete', [App\Http\Controllers\JobController::class, 'destroy']);

    
});