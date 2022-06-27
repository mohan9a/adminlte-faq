<?php
use Illuminate\Support\Facades\Route;
use Mohan9a\AdminlteFaq\Http\Controllers\FAQController;

//Route::get('faqs', [FAQController::class, 'index'])->name('faqs.index');
Route::post('faq/order', [FAQController::class, 'order_item'])->name('faqs.order_item');
Route::resource('faqs', FAQController::class);