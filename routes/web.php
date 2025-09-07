<?php

use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Home\CartPage;
use App\Livewire\Home\OrderPage;
use App\Livewire\Home\ProductDetail;
use App\Livewire\Home\ProductPage;
use App\Livewire\Landing\LandingPage;
use Illuminate\Support\Facades\Route;

Route::get("/", LandingPage::class)->name('home');

// Auth
Route::get("/login", LoginPage::class)->name("login");
Route::get("/register", RegisterPage::class)->name("register");

Route::middleware(["auth"])->group(function() {
    // HomePage
    Route::get("/home", App\Livewire\Home\Index::class)->name('home.index')->middleware("isUser");
    Route::get("/products", ProductPage::class)->name('home.product')->middleware("isUser");
    Route::get("/keranjang", CartPage::class)->name("home.cart")->middleware("isUser");
    Route::get("/product/{id}", ProductDetail::class)->name('home.product.detail')->middleware("isUser");
    Route::get("/orders", OrderPage::class)->name("home.order")->middleware("isUser");

    Route::prefix("umkn")->group(function() {
        Route::get("/", App\Livewire\Home\Umkn\Dashboard::class)->name("umkn.dashboard");

        Route::get("/products", App\Livewire\Home\Umkn\Product\Index::class)->name('home.umkn.product.index');
    })->middleware("isUmkn");
});

