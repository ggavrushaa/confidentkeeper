<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;
use Illuminate\Support\Facades\Blade;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Schema::defaultStringLength(191);
        $this->app->register(PasswordResetServiceProvider::class);

        Blade::directive('activeLink', function ($route) {
            return "<?php echo request()->routeIs($route) ? 'style=\"color: #0D6EFD\"' : ''; ?>";
        });
    }
}
