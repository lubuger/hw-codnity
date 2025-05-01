<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('news', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');
});
