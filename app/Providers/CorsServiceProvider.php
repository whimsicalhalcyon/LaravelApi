<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CorsServiceProvider extends ServiceProvider
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
        // Получаем разрешенные сайты из БД с кэшированием
        $allowedOrigins = $this->getAllowedOriginsFromDatabase();

        // Обновляем конфигурацию CORS
        Config::set('cors.allowed_origins', $allowedOrigins);
    }

    /**
     * Получение разрешенных сайтов из базы данных
     */
    private function getAllowedOriginsFromDatabase(): array
    {

        return Cache::remember('cors_allowed_origins', 3600, function () {
            try {
                $sites = DB::table('cors_urls')
                    ->pluck('url')
                    ->toArray();

                $defaultOrigins = [
                    'http://localhost:3000',
                    'http://localhost:8080',
                    'http://localhost:8000',
                ];

                $allOrigins = array_unique(array_merge($sites, $defaultOrigins));


                $allOrigins = array_map(function($url) {
                    return rtrim($url, '/');
                }, $allOrigins);

                return $allOrigins;
            } catch (\Exception $e) {
                return $this->getDefaultOrigins();
            }
        });
    }

    /**
     * Дефолтные разрешенные источники
     */
    private function getDefaultOrigins(): array
    {
        return [
            'http://localhost:3000',
            'http://localhost:8080',
            'http://localhost:8000',
        ];
    }
}
