<?php

header('Content-Type: application/json');

// Sostituisci i segnaposto con le tue informazioni sul database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "prenotazionecinema";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$mysqli = new mysqli($servername, $username, $password, $dbname);
$mysqli->set_charset('utf8mb4');
    

$utenti = [];
$result = $mysqli->query("SELECT * FROM utente");
while(($row = $result->fetch_assoc()) != null){
    $utenti[] = $row;
}

echo json_encode($utenti);