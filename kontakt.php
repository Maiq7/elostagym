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
  $to      = "maik.kistner@gmx.de";  // <- Hier deine Zieladresse eintragen
  $subject = "Neue Reservierung von $vorname $nachname";
  $message = "
    Neue Anfrage über das Formular:

    Vorname: $vorname
    Nachname: $nachname
    Telefon: $telefon
    E-Mail: $email
    Bevorzugter Standort: $standort
  ";

  $headers = "From: kontaktformular@elosta.de\r\n" .
             "Reply-To: $email\r\n" .
             "Content-Type: text/plain; charset=UTF-8\r\n";

  // E-Mail senden
  if (mail($to, $subject, $message, $headers)) {
  echo "<!DOCTYPE html>
  <html lang='de'>
  <head>
    <meta charset='UTF-8'>
    <meta http-equiv='refresh' content='2;url=angebot.html'>
    <title>Erfolgreich gesendet</title>
    <link href='https://cdn.tailwindcss.com' rel='stylesheet'>
  </head>
  <body class='bg-white text-black flex items-center justify-center h-screen'>
    <div class='text-center'>
      <div class='text-emerald-500 text-4xl mb-4'>✔</div>
      <h2 class='text-xl font-semibold mb-2'>Deine Anfrage wurde erfolgreich übermittelt!</h2>
      <p class='text-gray-600'>Du wirst gleich zur Angebotsseite weitergeleitet ...</p>
    </div>
  </body>
  </html>";
  exit;
}

  else {
    echo "Es gab ein Problem beim Versenden der Nachricht.";
  }
}
?>
