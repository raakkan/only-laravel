<?php

use Illuminate\Support\Facades\Route;
use Raakkan\OnlyLaravel\Installer\Livewire\Installer;


Route::get('installer', Installer::class)->name('installer')
    ->middleware(['web']);

// Route::get('/installed', function () {
//     return view('web-installer::success');
// })->name('installer.success')->middleware(['web', 'redirect.if.not.installed']);