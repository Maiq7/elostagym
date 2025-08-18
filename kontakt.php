<?php
// Sicherheitsprüfung
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $vorname   = htmlspecialchars(trim($_POST["vorname"]));
  $nachname  = htmlspecialchars(trim($_POST["nachname"]));
  $telefon   = htmlspecialchars(trim($_POST["telefon"]));
  $email     = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $standort  = htmlspecialchars(trim($_POST["standort"]));
  $dsgvo     = isset($_POST["dsgvo"]);

  if (!$dsgvo || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Ungültige Eingaben oder DSGVO nicht bestätigt.");
  }

  // E-Mail vorbereiten
  $to      = "info@elostagym.de";
  $subject = "Neue Reservierung von $vorname $nachname";
  $message = "
    Neue Anfrage über das Formular:

    Vorname: $vorname
    Nachname: $nachname
    Telefon: $telefon
    E-Mail: $email
    Bevorzugter Standort: $standort
  ";

  $headers = "From: info@elostagym.de\r\n" .
             "Reply-To: $email\r\n" .
             "Content-Type: text/plain; charset=UTF-8\r\n";

  // E-Mail senden
  if (mail($to, $subject, $message, $headers)) {
    header("Location: danke.html");
    exit;
  } else {
    echo "Es gab ein Problem beim Versenden der Nachricht.";
    exit;
  }
}
?>
