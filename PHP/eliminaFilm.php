<?php

    include("classi/CDatabase.php");

    if(isset($_SESSION)){
        session_start();
    }

    //controllo se l'utente è un admin
    if(isset($_SESSION["admin"])){
        echo "accesso negato";
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        //id del film da eliminare
        $idFilm = $_POST["id"];

        //mi collego al db
        $classeDB = new CDatabase();
        $classeDB->connessione();

        //query
        $query = "DELETE FROM film WHERE ID=?";
        $tipo = "i";

        //elimina il film
        if($classeDB->elimina($query, $tipo, $idFilm)){
            echo "200"; //film eliminato
        }
        else{
            echo "404"; //film non eliminato
        }

        $classeDB->chiudiConnessione();
    }