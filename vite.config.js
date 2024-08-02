import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import vue from '@vitejs/plugin-vue';

export default ({ mode }) => {
    process.env = { ...process.env, ...loadEnv(mode, path.join(__dirname, "../../../"), '') };

    return defineConfig({
        plugins: [
            laravel({
                hotFile: '../../../storage/vite.hot',
                input: ['resources/js/menu.ts', 'resources/js/page-builder.ts', 'resources/css/base.css'],
                refresh: true,
            }),
            vue(),
        ],
        build: {
            outDir: path.join(__dirname, "../../../public/build/"),
        },
        resolve: {
            alias: {
                'vue': 'vue/dist/vue.esm-bundler.js',
                '@': path.resolve(__dirname, './resources/js'),
            },
        },
    });
}