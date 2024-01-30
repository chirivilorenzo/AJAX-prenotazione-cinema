<?php
    if(!isset($_SESSION)){
        session_start();
    }


    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "prenotazionecinema";

        
        $titolo = $_POST["titolo"];
        $durata = $_POST["durata"];
        $img = $_POST["immagine"];
        
        
        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $mysqli->set_charset('utf8mb4');


        $query = "INSERT INTO utente (titolo, durata, locandina) VALUES ('$titolo', '$durata', '$img')";
        
        if ($mysqli->query($query) === TRUE) {
            echo "200";
        }
        else {
            echo "300";
        }
        $mysqli->close();
    }