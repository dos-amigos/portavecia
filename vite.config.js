import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [tailwindcss()],
  build: {
    manifest: true,
    outDir: 'dist',
    rollupOptions: {
      input: 'src/js/main.js',
    },
  },
  server: {
    port: 5173,
    strictPort: true,
  },
})
