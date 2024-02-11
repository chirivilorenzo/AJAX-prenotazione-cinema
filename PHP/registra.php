<?php

    include("classi/CDatabase.php");

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        //connessione al db
        $classeDB = new CDatabase();
        $classeDB->connessione();

        //variabili prese in post
        $user = $_POST["username"];
        $psw = md5($_POST["password"]);
        $email = $_POST["email"];

        //inserisco nel db l'utente
        $query = "INSERT INTO utente (username, password, email) VALUES (?, ?, ?)";
        $tipo = "sss";

        if($classeDB->inserisci($query, $tipo, $user, $psw, $email)){
            echo "200"; //utente inserito
        }
        else{
            echo "301"; //utente non inserito
        }

        $classeDB->chiudiConnessione();
    }