import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // Tambahkan konfigurasi build ini:
    build: {
        outDir: 'public/build', // Vercel akan mencari file di sini
        emptyOutDir: true,
    },
});