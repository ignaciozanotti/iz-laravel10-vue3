import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.js'],
      refresh: true,
    }),
    vue(),
  ],
  // Vite needs to bind to 0.0.0.0 (all interfaces) inside the container so it’s accessible from the host via localhost:5173 // ended up adding --host for dev script in src/package.json
  /*
  server: {
    host: '0.0.0.0', // Bind to all interfaces
    port: 5173,
  },
  */
});