<?php

use App\Livewire\InfoFeed;
use App\Livewire\PublicOrderForm;
use Illuminate\Support\Facades\Route;

Route::get('/', PublicOrderForm::class)->name('home');
Route::get('/info', InfoFeed::class)->name('info');
