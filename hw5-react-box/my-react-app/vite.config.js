import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// You MUST set the base property for GitHub Pages deployment.
export default defineConfig({
  plugins: [react()],
  base: '/cs20/', 
})
