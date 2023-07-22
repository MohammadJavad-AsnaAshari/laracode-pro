<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::get("/", function () {
    return view("admin.index");
});

Route::resource("users", UserController::class);
