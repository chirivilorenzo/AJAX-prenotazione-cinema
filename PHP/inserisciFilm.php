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
        
        
        // Ottieni l'immagine dal form e salvala nel server
        $imgTmpName = $_FILES['immagine']['tmp_name'];
        $imgContent = file_get_contents($imgTmpName);

        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $mysqli->set_charset('utf8mb4');

        $query = "INSERT INTO film (titolo, durata, locandina) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('sss', $titolo, $durata, $imgContent);

        if ($stmt->execute()) {
            echo "200";
        }
        else {
            echo "300";
        }

        $stmt->close();
        $mysqli->close();
    }