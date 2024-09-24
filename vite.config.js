import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/guest.css',
                'resources/css/app.css',
                'resources/js/post.js',
            ],
            refresh: true,
        }),
    ],
});
