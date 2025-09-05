<?php

use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Home\CartPage;
use App\Livewire\Home\ProductDetail;
use App\Livewire\Home\ProductPage;
use App\Livewire\Landing\LandingPage;
use Illuminate\Support\Facades\Route;

Route::get("/", LandingPage::class)->name('home');

// Auth
Route::get("/login", LoginPage::class)->name("login");
Route::get("/register", RegisterPage::class)->name("register");

// HomePage
Route::get("/home", App\Livewire\Home\Index::class)->name('home.index');
Route::get("/products", ProductPage::class)->name('home.product');
Route::get("/keranjang", CartPage::class)->name("home.cart");
Route::get("/product/{id}", ProductDetail::class)->name('home.product.detail');