<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Models\Download;
use App\Http\Controllers\EarlyAccessController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/prompt-builder', \App\Livewire\PromptBuilder::class)->name('prompt-builder');

Route::get('/download/spbible', function () {
    // Track the download
    Download::create([
        'resource_name' => 'System prompts for beginners',
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);

    $filePath = public_path('SPBible.pdf');
    
    if (file_exists($filePath)) {
        return Response::download($filePath, 'System-Prompts-Bible.pdf');
    } else {
        abort(404, 'File not found');
    }
})->name('download.spbible');

// Early Access Signup API Routes
Route::post('/api/early-access/signup', [EarlyAccessController::class, 'store'])->name('early-access.signup');
Route::get('/api/early-access/stats', [EarlyAccessController::class, 'stats'])->name('early-access.stats');
