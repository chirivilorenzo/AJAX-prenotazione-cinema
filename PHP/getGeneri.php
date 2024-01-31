<?php
    if(!isset($_SESSION)){
        session_start();
    }

    header('Content-Type: application/json');

    
    if($_SERVER["REQUEST_METHOD"] === "GET"){
        
        //mi collego al db e cerco l'utente
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "prenotazionecinema";

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $mysqli->set_charset('utf8mb4');

        $result = $mysqli->query("SELECT * FROM genere");

        $generi = [];
        while($row = $result->fetch_assoc()){
            $generi[] = $row;
        }

        echo json_encode($generi);
    }
    else{
        echo "401";
    }