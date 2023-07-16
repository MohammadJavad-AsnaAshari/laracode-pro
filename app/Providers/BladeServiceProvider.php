<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive("recaptcha", function (){
            return '
                <script src=\'https://www.google.com/recaptcha/api.js\' async defer></script>
                <div class=\'g-recaptcha <?php if($errors->has(\'g-recaptcha-response\')) : ?> is-invalid <?php endif; ?>\' data-sitekey=\'{{ env(\'GOOGLE_RECAPTCHA_SITE_KEY\') }}\'></div>
            ';
        });
    }
}
