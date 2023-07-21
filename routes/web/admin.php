<?php

use Illuminate\Support\Facades\Route;


Route::get("/", function () {
    return view("admin.master");
});

Route::get("/fuck", function () {
    return "fuck";
});
