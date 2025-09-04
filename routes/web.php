<?php

use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Landing\LandingPage;
use Illuminate\Support\Facades\Route;

Route::get("/", LandingPage::class)->name('home');

// Auth
Route::get("/login", LoginPage::class)->name("login");
Route::get("/register", RegisterPage::class)->name("register");