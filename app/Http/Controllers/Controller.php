<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTraits;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, SEOToolsTraits;
}
