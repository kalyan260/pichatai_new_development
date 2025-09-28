<?php
use App\Http\Controllers\Docs;

Route::get('docs',[Docs::class,'installation'])->middleware(['auth'])->name('docs');
Route::get('docs/admin',[Docs::class,'administration'])->middleware(['auth'])->name('docs-admin');
Route::get('docs/tools',[Docs::class,'tools'])->middleware(['auth'])->name('docs-tools');
