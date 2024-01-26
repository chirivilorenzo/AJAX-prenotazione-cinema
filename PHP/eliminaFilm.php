<?php

    if(isset($_SESSION)){
        session_start();
    }

    if(isset($_SESSION["admin"])){
        echo "accesso negato";
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $idFilm = $_POST["id"];

        //collegamento al db per eliminare quel film (se esiste)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "prenotazionecinema";


        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $mysqli->set_charset('utf8mb4');

        $mysqli->query("DELETE FROM film WHERE ID='$idFilm'");
        echo $mysqli->error;
        if($mysqli->affected_rows > 0){
            echo "200";
        }
        else{
            echo "404";
        }
    }