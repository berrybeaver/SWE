<?php
function connect_db ()
{
    $link = new mysqli("localhost", // Host der Datenbank
        "root",                    // Benutzername zur Anmeldung
        "root",                // Passwort
        "swe-d7"          // Auswahl der Datenbanken (bzw. des Schemas)
// optional port der Datenbank
    );

    if ($link->connect_error) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }

    return $link;
}

function termin_hinzufuegen($titel, $ort, $start_d, $start_t, $end_d, $end_t, $teilnehmer, $technik) {
    $link = connect_db();

    $sql = "INSERT INTO termin (titel, ort, start_d, start_t, end_d, end_t)	VALUES ('$titel','$ort','$start_d','$start_t','$end_d','$end_t')";
    $link->query($sql);

    $sql = "INSERT INTO termin_teilnehmer (termin_id, ma_id) VALUES (, $teilnehmer) ";
    $link->query($sql);
    $sql = "INSERT INTO benoetigte_technik (technik_id, termin_id) VALUES ($technik, )";
    $link->query($sql);

}
