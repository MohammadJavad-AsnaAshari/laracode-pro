<?php

use App\Http\Controllers\Auth\AuthTokenController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Profile\IndexController;
use App\Http\Controllers\Profile\TokenAuthController;
use App\Http\Controllers\Profile\TwoFactorAuthController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

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
    $product = \App\Models\Product::find(3);

    auth()->user()->comments()->create([
        "comment" => "this is a comment 12:03",
        "commentable_id" => $product->id,
        "commentable_type" => get_class($product)
    ]);
    return $product->comments()->get();

    auth()->loginUsingId(15);
    return view('welcome');
});

Auth::routes(["verify" => true]);
Route::get("/auth/google", [GoogleAuthController::class, "redirect"])->name("auth.google");
Route::get("/auth/google/callback", [GoogleAuthController::class, "callback"]);

Route::get("/auth/token", [AuthTokenController::class, "getToken"])->name("2fa.token");
Route::post("/auth/token", [AuthTokenController::class, "postToken"]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix("profile")->middleware(["auth", "verified"])->group(function () {
    Route::get("/", [IndexController::class, "index"])->name("profile");
    Route::get("/twofactorauth", [TwoFactorAuthController::class, "manageTwoFactorAuth"])->name("profile.2fa.manage");
    Route::post("/twofactorauth", [TwoFactorAuthController::class, "postManageTwoFactorAuth"]);

    Route::get("/twofactorauth/phone", [TokenAuthController::class, "getPhoneVerify"])->name("profile.2fa.phone");
    Route::post("/twofactorauth/phone", [TokenAuthController::class, "postPhoneVerify"]);

});


Route::get("/secret", function () {
    return "secret";
})->middleware("password.confirm");

Route::get("products", [ProductController::class, "index"]);
Route::get("products/{product}", [ProductController::class, "single"]);
