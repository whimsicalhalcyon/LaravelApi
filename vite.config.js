import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/reply.js', 'resources/js/cors.js', 'resources/js/contact.js', "resources/js/widget.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],server: {
        proxy: {
            '/api': 'http://restapi.local'
        },
        host: true,
        allowedHosts: [
            'ab127ef4baff27.lhr.life',
            '1630c1342be012.lhr.life',
            '50890b6084e3b6.lhr.life',
            'f8617681d5b7fb.lhr.life'
        ],
        cors: {
            origin: [
                'http://restapi.local',
                'http://127.0.0.1:5173',
                'http://localhost:5173',
            ],
            credentials: true,
        },
        hmr: {
            host: 'localhost',
        },
    },
});
