<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LetterController;
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

Route::get('/pdf', function () {
    return view('tes');
});
Route::get('/app', function () {
    return view('apps');
});




Route::get('/view-letter/{id}', [LetterController::class, 'viewLetter'])->name('view.letter');
Route::get('/download-letter/{id}', [LetterController::class, 'downloadLetter'])->name('download.letter');



