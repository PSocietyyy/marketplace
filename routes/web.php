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

    Route::get("/profile", App\Livewire\Home\ProfilePage::class)->name("home.profile");

    Route::get("/profile/umkn/{id}", App\Livewire\Home\UmknProfile::class)->name('home.profile.umkn');

    Route::prefix("umkn")->group(function() {
        Route::get("/", App\Livewire\Home\Umkn\Dashboard::class)->name("home.umkn.dashboard");

        Route::get("/products", App\Livewire\Home\Umkn\Product\Index::class)->name('home.umkn.product.index');
        Route::get("/products/create", App\Livewire\Home\Umkn\Product\ProductForm::class)->name('home.umkn.product.form.create');
        Route::get("/products/{id}/edit", App\Livewire\Home\Umkn\Product\ProductForm::class)->name('home.umkn.product.form.edit');
        Route::get("/products/{id}", App\Livewire\Home\Umkn\Product\Detail::class)->name("home.umkn.product.detail");

        Route::get("/orders", App\Livewire\Home\Umkn\OrderPage::class)->name('home.umkn.orders');
    })->middleware("isUmkn");
});


Route::prefix("admin")->as("admin.")->middleware("isAdmin")->group(function () {
    Route::get("/", App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get("/products", App\Livewire\Admin\Product\Index::class)->name('product.index');
    Route::get("/products/{id}", App\Livewire\Admin\Product\Detail::class)->name('product.detail');
    Route::get("/categories", App\Livewire\Admin\Categories\Index::class)->name('categories.index');

    // Order
    Route::get("/orders", App\Livewire\Admin\OrderPage::class)->name('orders');

    // Pengajuan UMKN
    Route::get("/umkn_registrations", App\Livewire\Admin\UmknRegistrationPage::class)->name('umkn_registration');
});