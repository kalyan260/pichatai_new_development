<?php
use App\Http\Controllers\Landing;

// Route::any('/policy/privacy', [Landing::class,'policy_privacy'])->name('policy-privacy');
// Route::any('/policy/terms', [Landing::class,'policy_terms'])->name('policy-terms');
// Route::any('/policy/refund', [Landing::class,'policy_refund'])->name('policy-refund');
// Route::any('/policy/gdpr', [Landing::class,'policy_gdpr'])->name('policy-gdpr');

Route::any('/policy/{url}', [Landing::class,'policy_static'])->name('policy-static');

Route::any('/pricing', [Landing::class,'pricing_plan'])->name('pricing-plan');
Route::any('/pricing-ajax', [Landing::class,'pricing_plan_ajax'])->name('pricing-ajax');
Route::any('/contact-us', [Landing::class,'contact_us'])->name('contact-us');
Route::any('/accept-cookie', [Landing::class,'accept_cookie'])->name('accept-cookie');
Route::post('/installation-submit', [Landing::class,'installation_submit'])->name('installation-submit');

Route::get('/faqs', [Landing::class,'faq'])->name('faqs');

Route::prefix('blogs')->name('blogs.')->group(function () {
	Route::get('/', [Landing::class, 'blog_index'])->name('view');
	Route::get('/details/{id}', [Landing::class, 'blog_details'])->name('details');
});