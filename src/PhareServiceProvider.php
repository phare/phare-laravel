<?php

namespace Phare\PhareLaravel;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PhareServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/phare.php' => config_path('phare.php'),
        ], 'phare-config');

        Blade::directive('phare', function ($expression): ?string {
            return "<?php echo \Phare\PhareLaravel\Script::render($expression); ?>";
        });
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/phare.php',
            'phare'
        );
    }
}
