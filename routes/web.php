<?php

use App\Livewire\Admin\Admin;
use Illuminate\Support\Facades\Route;
use Raakkan\OnlyLaravel\Installer\Livewire\Installer;
use Raakkan\OnlyLaravel\Installer\Http\Middleware\InstallationMiddleware;

// Route::get('admin', Admin::class)->name('installer')
//     ->middleware(['web']);

Route::get('installer/{step?}', Installer::class)->name('installer')
    ->middleware(['web', InstallationMiddleware::class]);

// Route::get('/installed', function () {
//     return view('web-installer::success');
// })->name('installer.success')->middleware(['web', 'redirect.if.not.installed']);

// Route::middleware('web')->get('/mary/toogle-sidebar', function (Request $request) {
//     if ($request->collapsed) {
//         session(['mary-sidebar-collapsed' => $request->collapsed]);
//     }
// })->name('mary.toogle-sidebar');
