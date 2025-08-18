<?php
// Empfängeradresse (deine E-Mail-Adresse eintragen!)
$empfaenger = "info@elostagym.de";

// Formularfelder filtern
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$nachricht = htmlspecialchars(trim($_POST['nachricht'] ?? ''));
$dsgvo = isset($_POST['dsgvo']);

// Pflichtfeldprüfung inkl. DSGVO-Zustimmung
if (empty($name) || empty($email) || !$dsgvo) {
    echo "<h2 style='font-family:sans-serif; color:red;'>Bitte füllen Sie alle Pflichtfelder korrekt aus und akzeptieren Sie die Datenschutzerklärung.</h2>";
    exit;
}

// Nachricht an Studio
$betreffStudio = "Neue Kündigung von $name";
$textStudio = "Neue Kündigungs-Anfrage:\n\n"
            . "Name: $name\n"
            . "E-Mail: $email\n\n"
            . "Nachricht:\n$nachricht";
$headerStudio = "From: $email\r\n"
              . "Reply-To: $email\r\n"
              . "Content-Type: text/plain; charset=utf-8\r\n";

// Nachricht an Nutzer
$betreffUser = "Deine Kündigung bei El Osta Gym";
$textUser = "Hallo $name,\n\n"
          . "vielen Dank für deine Kündigung bei El Osta Gym!\n"
          . "Schade das du gehst!\n"
          . "Wir melden uns in Kürze bei dir.\n\n"
          . "Deine Angaben:\n"
          . "Name: $name\n"
          . "E-Mail: $email\n"
          . (!empty($nachricht) ? "Nachricht: $nachricht\n\n" : "\n")
          . "Mit sportlichen Grüßen\nEl Osta Gym";
$headerUser = "From: info@elostagym.de\r\n"
            . "Reply-To: info@elostagym.de\r\n"
            . "Content-Type: text/plain; charset=utf-8\r\n";

// E-Mails senden
$mailErfolgStudio = mail($empfaenger, $betreffStudio, $textStudio, $headerStudio);
$mailErfolgUser = mail($email, $betreffUser, $textUser, $headerUser);

// Weiterleitung oder Fehlermeldung
if ($mailErfolgStudio && $mailErfolgUser) {
    header("Location: danke.html");
    exit;
} else {
    echo "<h2 style='font-family:sans-serif; color:red;'>Fehler: Die Nachricht konnte nicht gesendet werden.</h2>";
}
?>
