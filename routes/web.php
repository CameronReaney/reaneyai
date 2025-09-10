<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Models\Download;

Route::get('/', function () {
    return view('welcome');
});

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
