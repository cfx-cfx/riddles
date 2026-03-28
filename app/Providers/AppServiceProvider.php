<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
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
        // директива @honeypot, добавляет в форму скрытое поле для ловли ботов
        Blade::directive('honeypot', function () {
            return '<input type="text" name="surname" style="display:none">';
        });

        // выбрасывать исключения при массовом присваивании, если св-во не включено в $fillable
        Model::preventSilentlyDiscardingAttributes(!app()->isProduction());
    }
}
