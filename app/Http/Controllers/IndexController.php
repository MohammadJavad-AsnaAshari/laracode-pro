<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $this->seo()
            ->setTitle("Main Page")
            ->setDescription("Welcome to Laravelpro main page");
        return view("seo");
    }
}
