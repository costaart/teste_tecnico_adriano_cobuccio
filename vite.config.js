import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],

    server: {
        // Watch mais confiável em Docker/WSL
        watch: {
            usePolling: true,
            interval: 500,
        },

        // Expor o dev server pra fora (containers enxergarem)
        host: '0.0.0.0',
        port: 5173,

        // HMR: o navegador fala com localhost:5173
        hmr: {
            host: 'localhost',
            port: 5173,
        },
    },
});
