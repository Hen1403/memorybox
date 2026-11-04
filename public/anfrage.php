<?php
// Verarbeitet das Anfrageformular: Mail an memorybox + Bestätigung an den Interessenten.
// Läuft nur auf dem Server des Hosting-Anbieters (lokal gibt es kein PHP).

// ---- Einstellungen (nach Einrichtung des Postfachs anpassen) ----
$EMPFAENGER = 'memorybox.fotobox@gmail.com';    // hier kommen die Anfragen an
$ABSENDER   = 'anfrage@memoryboxfotobox.de';     // Postfach der eigenen Domain
$NAME       = 'memorybox – Die Fotobox aus Holz';
// -----------------------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /anfrage/');
    exit;
}

function feld($name) {
    $wert = isset($_POST[$name]) ? trim((string) $_POST[$name]) : '';
    return str_replace(["\r", "\n"], ' ', strip_tags($wert));
}

// Spam-Falle: echte Besucher sehen dieses Feld nicht
if (feld('website') !== '') {
    header('Location: /danke/');
    exit;
}

$datum     = feld('datum') ?: feld('datum_ohne_js');
$vorname   = feld('vorname');
$nachname  = feld('nachname');
$email     = filter_var(feld('email'), FILTER_VALIDATE_EMAIL);
$telefon   = feld('telefon');
$ort       = feld('ort');
$gaeste    = feld('gaeste');
$anlass    = feld('anlass');
$paket     = feld('paket');
$extras    = isset($_POST['extras']) && is_array($_POST['extras']) ? implode(', ', array_map('strip_tags', $_POST['extras'])) : '';
$nachricht = isset($_POST['nachricht']) ? trim(strip_tags((string) $_POST['nachricht'])) : '';

if (!$datum || !$vorname || !$nachname || !$email || feld('datenschutz') !== 'ja') {
    http_response_code(400);
    echo 'Bitte fülle alle Pflichtfelder aus. <a href="/anfrage/">Zurück zum Formular</a>';
    exit;
}

$datumLesbar = date('d.m.Y', strtotime($datum));

$zusammenfassung = "Wunschtermin: $datumLesbar\n"
    . "Anlass: $anlass\n"
    . "Paket: $paket\n"
    . ($extras ? "Extras: $extras\n" : '')
    . ($ort ? "Ort: $ort\n" : '')
    . ($gaeste ? "Gäste: ca. $gaeste\n" : '');

$anDich = "Neue Anfrage über die Website\n\n"
    . $zusammenfassung
    . "\nName: $vorname $nachname\n"
    . "E-Mail: $email\n"
    . ($telefon ? "Telefon: $telefon\n" : '')
    . ($nachricht ? "\nNachricht:\n$nachricht\n" : '');

$anKunde = "Hallo $vorname,\n\n"
    . "danke für deine Anfrage! Ich prüfe deinen Termin und melde mich innerhalb von 24 Stunden mit einem Angebot.\n\n"
    . "Deine Angaben:\n$zusammenfassung\n"
    . "Bis bald\nTom von memorybox\n\n"
    . "memorybox – Die Fotobox aus Holz · Bad Hersfeld";

function senden($an, $betreff, $text, $absender, $name, $antwortAn) {
    $kopf = [
        'From: ' . mb_encode_mimeheader($name) . " <$absender>",
        "Reply-To: $antwortAn",
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
    ];
    return mail($an, mb_encode_mimeheader($betreff), $text, implode("\r\n", $kopf), "-f$absender");
}

senden($EMPFAENGER, "Anfrage $datumLesbar – $vorname $nachname", $anDich, $ABSENDER, $NAME, $email);
senden($email, 'Deine Anfrage bei memorybox', $anKunde, $ABSENDER, $NAME, $EMPFAENGER);

header('Location: /danke/');
exit;
