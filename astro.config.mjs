import { defineConfig } from 'astro/config';

// Domain eintragen, sobald sie bestellt ist (wird für Sitemap, Canonical und Kalender-Abo gebraucht).
// Für die GitHub-Pages-Vorschau setzt der Workflow SEITE und BASIS (Unterordner /memorybox/).
export default defineConfig({
  site: process.env.SEITE || 'https://www.memoryboxfotobox.de',
  base: process.env.BASIS || '/',
  trailingSlash: 'always',
  build: { format: 'directory' },
});
