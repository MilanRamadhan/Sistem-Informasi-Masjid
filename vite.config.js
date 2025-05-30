import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        host: "0.0.0.0",
        port: 5173, // Port default Vite, biarkan
        hmr: {
            host: "masjid-app.test", // Ganti dengan nama virtual host Anda
            clientPort: 5173, // Port yang sama dengan Vite server
        },
    },
});
