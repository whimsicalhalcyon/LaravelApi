<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Обработка запроса с CORS.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Заголовки CORS
        $headers = [
            'Access-Control-Allow-Origin' => 'http://localhost:5173', // фронтенд
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Requested-With, Authorization',
        ];

        // Если это preflight OPTIONS — просто возвращаем заголовки
        if ($request->getMethod() === 'OPTIONS') {
            return response()->json([], 200, $headers);
        }

        // Иначе пропускаем запрос дальше
        $response = $next($request);

        // Добавляем заголовки к ответу
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}
