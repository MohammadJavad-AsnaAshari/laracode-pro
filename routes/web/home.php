<?php

use App\Http\Controllers\Auth\AuthTokenController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Profile\IndexController;
use App\Http\Controllers\Profile\OrderController;
use App\Http\Controllers\Profile\TokenAuthController;
use App\Http\Controllers\Profile\TwoFactorAuthController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    auth()->loginUsingId(15);
    return view('welcome');
});

Auth::routes(["verify" => true]);
Route::get("/auth/google", [GoogleAuthController::class, "redirect"])->name("auth.google");
Route::get("/auth/google/callback", [GoogleAuthController::class, "callback"]);

Route::get("/auth/token", [AuthTokenController::class, "getToken"])->name("2fa.token");
Route::post("/auth/token", [AuthTokenController::class, "postToken"]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(["auth", "verified"])->group(function () {
    Route::prefix("profile")->group(function () {
        Route::get("/", [IndexController::class, "index"])->name("profile");
        Route::get("/twofactorauth", [TwoFactorAuthController::class, "manageTwoFactorAuth"])->name("profile.2fa.manage");
        Route::post("/twofactorauth", [TwoFactorAuthController::class, "postManageTwoFactorAuth"]);

        Route::get("/twofactorauth/phone", [TokenAuthController::class, "getPhoneVerify"])->name("profile.2fa.phone");
        Route::post("/twofactorauth/phone", [TokenAuthController::class, "postPhoneVerify"]);

        Route::get("orders", [OrderController::class, "index"])->name("profile.orders");
        Route::get("orders/{order}", [OrderController::class, "showDetails"])->name("profile.orders.detail");
        Route::get("orders/{order}/payment", [OrderController::class, "payment"])->name("profile.orders.payment");
    });
    Route::post("comments", [HomeController::class, "comment"])->name("send.comment");
    Route::post("payment", [PaymentController::class, "payment"])->name("cart.payment");
    Route::post("payment/callback", [PaymentController::class, "callback"])->name("payment.callback");
});


Route::get("/secret", function () {
    return "secret";
})->middleware("password.confirm");

Route::get("products", [ProductController::class, "index"]);
Route::get("products/{product}", [ProductController::class, "single"]);

Route::get("download/{user}/file", function () {
    return Storage::download(request("path"));
})->name("download.file")->middleware("signed");

Route::get("download/test", function () {
//    return route("download.file", ["user" => auth()->user()->id, "path" => "files/screenshot.png"]);
    return \Illuminate\Support\Facades\URL::temporarySignedRoute("download.file", now()->addMinutes(30), ["user" => auth()->user()->id, "path" => "files/screenshot.png"]);
});

Route::get("/seo", [\App\Http\Controllers\IndexController::class, "index"]);
