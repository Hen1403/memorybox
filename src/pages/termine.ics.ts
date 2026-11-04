// Kalender-Abo der belegten Tage (z. B. für die Kalender-App am Handy).
// Enthält bewusst keine Notizen – die Datei ist öffentlich abrufbar.
import termine from '../data/termine.json';

const ohneStriche = (d: string) => d.replaceAll('-', '');

function naechsterTag(d: string) {
  const datum = new Date(`${d}T12:00:00Z`);
  datum.setUTCDate(datum.getUTCDate() + 1);
  return datum.toISOString().slice(0, 10);
}

export function GET() {
  const jetzt = new Date().toISOString().replace(/[-:]/g, '').slice(0, 15) + 'Z';
  const events = termine.belegt.map((t) => [
    'BEGIN:VEVENT',
    `UID:${t.von}-${t.bis || t.von}@memorybox`,
    `DTSTAMP:${jetzt}`,
    `DTSTART;VALUE=DATE:${ohneStriche(t.von)}`,
    `DTEND;VALUE=DATE:${ohneStriche(naechsterTag(t.bis || t.von))}`,
    'SUMMARY:Memorybox belegt',
    'END:VEVENT',
  ].join('\r\n'));

  const ics = [
    'BEGIN:VCALENDAR',
    'VERSION:2.0',
    'PRODID:-//memorybox//Belegte Tage//DE',
    'X-WR-CALNAME:Memorybox Buchungen',
    ...events,
    'END:VCALENDAR',
  ].join('\r\n');

  return new Response(ics, { headers: { 'Content-Type': 'text/calendar; charset=utf-8' } });
}
