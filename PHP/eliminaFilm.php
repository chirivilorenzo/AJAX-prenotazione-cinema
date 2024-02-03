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
        $config = parse_ini_file("../CONFIGURAZIONE/config.ini", true);

        $servername = $config["database"]["servername"];
        $username = $config["database"]["username"];
        $password = $config["database"]["password"];
        $dbname = $config["database"]["dbname"];


        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $mysqli->set_charset('utf8mb4');

        $query = "DELETE FROM film WHERE ID=?";
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param("i", $idFilm);
        if($stmt->execute()){
            echo "200";
        }
        else{
            echo "404";
        }

        $stmt->close();
        $mysqli->close();
    }