import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    base: '/',
    plugins: [
        laravel({
            input: [
                'resources/styles/main.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        vue()
    ],
    resolve: { 
        alias: {
            '@': '/resources/js',
        },
    },
});
