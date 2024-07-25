import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/connexion.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // server: {
    //     hmr: { // hmr is : Hot Module Replacement which is a feature to update the application without refreshing the page
    //         port: 443,
    //     },
    // },
});
