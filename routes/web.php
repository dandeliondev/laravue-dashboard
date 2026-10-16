<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
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

// This is an admin dashboard — send the root straight to the dashboard (or login).
Route::redirect('/', '/dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // User management
    Route::resource('users', UserController::class);

    // Roles & permissions
    Route::resource('roles', RoleController::class)->except('show');

    // Analytics / reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // App settings
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Productivity & info pages (themed UI with demo data)
    Route::inertia('/activity', 'Activity/Index')->name('activity.index');
    Route::inertia('/notifications', 'Notifications/Index')->name('notifications.index');
    Route::inertia('/calendar', 'Calendar/Index')->name('calendar.index');
    Route::inertia('/kanban', 'Kanban/Index')->name('kanban.index');
    Route::inertia('/inbox', 'Inbox/Index')->name('inbox.index');
    Route::inertia('/faq', 'Faq/Index')->name('faq.index');

    // Collaboration & content pages (themed UI with demo data)
    Route::inertia('/chat', 'Chat/Index')->name('chat.index');
    Route::inertia('/contacts', 'Contacts/Index')->name('contacts.index');
    Route::inertia('/projects', 'Projects/Index')->name('projects.index');
    Route::inertia('/files', 'Files/Index')->name('files.index');
    Route::inertia('/todos', 'Todos/Index')->name('todos.index');
    Route::inertia('/gallery', 'Gallery/Index')->name('gallery.index');
    Route::inertia('/timeline', 'Timeline/Index')->name('timeline.index');
    Route::inertia('/tickets', 'Tickets/Index')->name('tickets.index');
    Route::inertia('/invoice', 'Invoice/Index')->name('invoice.index');
    Route::inertia('/pricing', 'Pricing/Index')->name('pricing.index');

    // Profile (current user)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
