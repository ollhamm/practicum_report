import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    server: {
        host: true, // penting agar Vite bisa diakses dari luar
        hmr: {
            host: 'localhost', // atau bisa juga gunakan IP lokal kamu
            protocol: 'ws',
        },
    },
});
