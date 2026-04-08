<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CorsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Получаем разрешенные сайты из БД с кэшированием
        $allowedOrigins = $this->getAllowedOriginsFromDatabase();

        // Обновляем конфигурацию CORS
        Config::set('cors.allowed_origins', $allowedOrigins);
    }

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
                    'http://localhost:5173', // добавляем локальный фронтенд
                ];

                $allOrigins = array_unique(array_merge($sites, $defaultOrigins));
                return array_map(fn($url) => rtrim($url, '/'), $allOrigins);

            } catch (\Exception $e) {
                return $this->getDefaultOrigins();
            }
        });
    }

    private function getDefaultOrigins(): array
    {
        return [
            'http://localhost:3000',
            'http://localhost:8080',
            'http://localhost:8000',
            'http://localhost:5173',
            'https://zdrav-nnov.mznn.ru'
        ];
    }
}
