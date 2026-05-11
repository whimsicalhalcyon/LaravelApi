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
            '7ef58da8915306.lhr.life',
            '8d0514118d2a3b.lhr.life',
            'a140d5217da49b.lhr.life'
        ],
        cors: {
            origin: [
                'http://restapi.local',
                'http://127.0.0.1:5173',
                'http://localhost:5173',
                'http://localhost:5174',
                'http://localhost:5175',
                'http://127.0.0.1:5174',
                'http://bitrix.local/'
            ],
            credentials: true,
        },
        port: 5173,
        hmr: {
            host: 'restapi.local',
        },
    },
});
