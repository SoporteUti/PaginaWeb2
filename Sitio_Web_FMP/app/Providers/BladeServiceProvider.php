<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(){
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(){
        Blade::directive('fecha', function ($fecha) {
            setlocale(LC_ALL, "es_SV");
            return "<?php echo (strftime('%A, %d de %B de %Y %H:%M %p', strtotime($fecha))); ?>";
        });
    }
}
