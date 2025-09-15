<?php

use App\Livewire\QuoteForm;
use Illuminate\Support\Facades\Route;

Route::get('/', QuoteForm::class)->name('home');
// Route::get('/', function () {
//     return view('welcome');
// });
