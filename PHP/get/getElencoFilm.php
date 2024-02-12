<?php

    include("../classi/CDatabase.php");

    header('Content-Type: application/json');

    $classeDB = new CDatabase();
    $classeDB->connessione();

    $query = "SELECT * FROM film";
    $result = $classeDB->seleziona($query, "");

    $film = array();
    foreach($result as $elemento){
        $film[] = $elemento;
    }

    echo json_encode($film);