<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Custom\Stablediffusion\IndexController;

Route::prefix('image-generator')->name('image-generator.')->group(function () {
	Route::get('/', [IndexController::class, 'index'])->name('view');
	Route::post('/', [IndexController::class, 'genareteImage'])->name('genarete');
}); 