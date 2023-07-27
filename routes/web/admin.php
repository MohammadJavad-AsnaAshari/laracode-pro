<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::get("/", function () {
    return view("admin.index");
});

Route::resource("users", UserController::class);
Route::resource("permissions", PermissionController::class);
Route::resource("roles", RoleController::class);
