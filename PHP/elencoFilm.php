<?php

    header('Content-Type: application/json');

    // Sostituisci i segnaposto con le tue informazioni sul database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "prenotazionecinema";

    $mysqli = new mysqli($servername, $username, $password, $dbname);
    $mysqli->set_charset('utf8mb4');


    $result = $mysqli->query("SELECT * FROM film");

    $film = array();
    while(($row = $result->fetch_assoc()) != null){
        $row["locandina"] = base64_encode($row['locandina']);
        $film[] = $row;
    }

    echo json_encode($film);