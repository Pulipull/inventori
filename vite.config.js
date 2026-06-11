import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // TAMBAHKAN INI:
    base: '/build/', 
    build: {
        outDir: 'public/build',
        emptyOutDir: true,
    },
});