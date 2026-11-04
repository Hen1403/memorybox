# memorybox – Website

Neue Website der Memorybox Fotobox. Gebaut mit Astro, ausgeliefert als reines HTML + ein PHP-Skript für das Anfrageformular.

## Inhalte ändern

Alle Inhalte liegen in `src/data/`:

| Datei | Inhalt |
|---|---|
| `termine.json` | belegte Tage für den Kalender |
| `pakete.json` | Pakete, Preise, Extras |
| `faq.json` | häufige Fragen |
| `galerie.json` | Galerie-Fotos |
| `anlaesse.json` | Hochzeit, Geburtstag, Firmenfeier |
| `site.json` | Kontakt, Claim, Bewertung |

Nach dem Livegang geht das bequem im Browser unter `/admin`.

## Lokal ansehen

Vorschau in der Claude-App (Browser-Pane, Konfiguration „memorybox“) oder:

```
npm run dev
```

## Vor dem Livegang

- [ ] Domain + Hosting-Paket mit PHP und E-Mail bestellen
- [ ] Domain in `astro.config.mjs` und `public/robots.txt` eintragen
- [ ] Postfach anlegen, Adressen oben in `public/anfrage.php` eintragen
- [ ] GitHub-Konto anlegen, Projekt hochladen, Repo-Name in `public/admin/config.yml` eintragen
- [ ] FTP-Zugangsdaten als GitHub-Secrets hinterlegen (`FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD`)
- [ ] Beispiel-Termine in `termine.json` löschen
- [ ] Alle Platzhalter `[…]` und Platzhalter-Fotos ersetzen
- [ ] Datenschutzerklärung mit Generator erstellen
- [ ] Google-Unternehmensprofil auf die neue Domain verlinken, Instagram-Bio-Link auf `/anfrage/`
- [ ] Kalender-Abo `https://DOMAIN/termine.ics` am Handy abonnieren
