import { defineConfig } from 'astro/config';

// Domain eintragen, sobald sie bestellt ist (wird für Sitemap, Canonical und Kalender-Abo gebraucht)
export default defineConfig({
  site: 'https://www.memoryboxfotobox.de',
  trailingSlash: 'always',
  build: { format: 'directory' },
});
