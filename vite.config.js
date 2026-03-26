import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],server: {
        host: true,
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
