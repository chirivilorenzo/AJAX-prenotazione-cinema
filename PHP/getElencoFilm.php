<?php

    header('Content-Type: application/json');

    // Sostituisci i segnaposto con le tue informazioni sul database
    $config = parse_ini_file("../CONFIGURAZIONE/config.ini", true);

    $servername = $config["database"]["servername"];
    $username = $config["database"]["username"];
    $password = $config["database"]["password"];
    $dbname = $config["database"]["dbname"];

    $mysqli = new mysqli($servername, $username, $password, $dbname);
    $mysqli->set_charset('utf8mb4');


    $result = $mysqli->query("SELECT * FROM film");

    $film = array();
    while(($row = $result->fetch_assoc()) != null){
        $film[] = $row;
    }

    echo json_encode($film);