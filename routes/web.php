<?php

use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Auth::routes(["verify" => true]);
Route::get("/auth/google", [\App\Http\Controllers\Auth\GoogleAuthController::class,"redirect"])->name("auth.google");
Route::get("/auth/google/callback", [\App\Http\Controllers\Auth\GoogleAuthController::class,"callback"]);

Route::get("/auth/token", [\App\Http\Controllers\Auth\AuthTokenController::class,"getToken"])->name("2fa.token");
Route::post("/auth/token", [\App\Http\Controllers\Auth\AuthTokenController::class,"postToken"]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get("/profile", [ProfileController::class, "index"])->name("profile");
Route::get("/profile/twofactorauth", [ProfileController::class, "manageTwoFactorAuth"])->name("profile.2fa.manage");
Route::post("/profile/twofactorauth", [ProfileController::class, "postManageTwoFactorAuth"]);

Route::get("/profile/twofactorauth/phone", [ProfileController::class, "getPhoneVerify"])->name("profile.2fa.phone");
Route::post("/profile/twofactorauth/phone", [ProfileController::class, "postPhoneVerify"]);


Route::get("/secret", function (){
    return "secret";
})->middleware("password.confirm");
