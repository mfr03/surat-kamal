<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\SuratKematianController;
use App\Http\Controllers\SuratKelahiranController;
use App\Http\Controllers\SuratController;


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
Route::get('/download-pengantar/{id}', [LetterController::class, 'downloadSuratPengantar'])->name('download.pengantar');
Route::get('/download-usaha/{id}', [LetterController::class, 'downloadSuratUsaha'])->name('download.usaha');
Route::get('/download-letter-lahir/{id}', [LetterController::class, 'downloadLetterLahir'])->name('download.lahir');
// routes/web.php
Route::get('/surat-kelahiran/{id}', [LetterController::class, 'showSurat'])->name('surat.show');


// Route to show Surat Kematian
Route::get('/surat-kematian/{id}', [LetterController::class, 'showSuratKematian'])->name('suratKematian.show');

// Route to download Surat Kematian
Route::get('/download-kematian/{id}', [LetterController::class, 'downloadLetterKematian'])->name('download.kematian');


// Route::get('/export-surat-kematian', [SuratKematianController::class, 'exportSuratKematian'])->name('export.suratKematian');

Route::get('/export-surat-kematian/month', [SuratKematianController::class, 'exportSuratKematianByMonth'])->name('export.suratKematianByMonth');


Route::get('/export-surat-kelahiran/month', [SuratKelahiranController::class, 'exportSuratKelahiranByMonth'])->name('export.suratKelahiranByMonth');

Route::get('/export-surat-pengantar/month', [SuratController::class, 'exportSuratPengantarByMonth'])->name('export.suratPengantarByMonth');
Route::get('/export-surat-usaha/month', [SuratController::class, 'exportSuratUsahaByMonth'])->name('export.suratUsahaByMonth');
