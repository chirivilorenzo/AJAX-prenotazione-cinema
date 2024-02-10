<?php

    include("classi/CDatabase.php");

    if(isset($_SESSION)){
        session_start();
    }

    if(isset($_SESSION["admin"])){
        echo "accesso negato";
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $idFilm = $_POST["id"];

        $classeDB = new CDatabase();
        $classeDB->connessione();

        $query = "DELETE FROM film WHERE ID=?";
        $tipo = "i";

        if($classeDB->elimina($query, $tipo, $idFilm)){
            echo "200";
        }
        else{
            echo "404";
        }

        $classeDB->chiudiConnessione();
    }