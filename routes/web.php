<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'home'])->name('home');
Route::get('/about', [PortfolioController::class, 'about'])->name('about');
Route::get('/experience', [PortfolioController::class, 'experience'])->name('experience');
Route::get('/skills', [PortfolioController::class, 'skills'])->name('skills');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/resume', [ResumeController::class, 'show'])->name('resume');
Route::get('/resume/download', [ResumeController::class, 'download'])->name('resume.download');
Route::get('/contact', [PortfolioController::class, 'contact'])->name('contact');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::middleware('guest')->group(function (): void {
    Route::get('/admin/login', [AuthController::class, 'create'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'store'])->middleware('throttle:5,1')->name('admin.login.store');
});

Route::get('/login', fn () => redirect()->route('login'))->name('admin.login');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/content/{type}', [ContentController::class, 'index'])->name('content.index');
    Route::post('/content/{type}', [ContentController::class, 'store'])->name('content.store');
    Route::put('/content/{type}/{id}', [ContentController::class, 'update'])->name('content.update');
    Route::delete('/content/{type}/{id}', [ContentController::class, 'destroy'])->name('content.destroy');
    Route::resource('projects', App\Http\Controllers\Admin\ProjectController::class)->except('show');
});
