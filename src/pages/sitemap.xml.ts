import anlaesse from '../data/anlaesse.json';

export function GET({ site }: { site: URL }) {
  const pfade = ['/', ...anlaesse.anlaesse.map((a) => `/${a.slug}/`), '/anfrage/', '/impressum/', '/datenschutz/'];
  const xml = `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
${pfade.map((p) => `  <url><loc>${new URL(p, site)}</loc></url>`).join('\n')}
</urlset>`;
  return new Response(xml, { headers: { 'Content-Type': 'application/xml' } });
}
