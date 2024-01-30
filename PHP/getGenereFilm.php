<?php

    header('Content-Type: application/json');

    // Sostituisci i segnaposto con le tue informazioni sul database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "prenotazionecinema";

    $genere = $_POST["genere"];

    $mysqli = new mysqli($servername, $username, $password, $dbname);
    $mysqli->set_charset('utf8mb4');

    $query = "SELECT film.*
                FROM film
                JOIN `film-genere` ON film.ID = `film-genere`.idFilm
                JOIN genere ON `film-genere`.idGenere = genere.ID
                WHERE genere.nome = '$genere'";

    $result = $mysqli->query($query);

    $film = array();

    if (!$result) {
        die("Errore nella query: " . $mysqli->error);
    }

    if($result->num_rows > 0){
        while(($row = $result->fetch_assoc()) != null){
            $row["locandina"] = base64_encode($row['locandina']);
            $film[] = $row;
        }

        echo json_encode($film);
    }
    else{
        echo "301";
    }

    