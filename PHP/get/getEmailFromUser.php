<?php

    include("../classi/CDatabase.php");

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $user = $_POST["username"];

        $classeDB = new CDatabase();
        $classeDB->connessione();

        $query = "SELECT email FROM utente WHERE username = ?";
        $tipo = "s";
        $result = $classeDB->seleziona($query, $tipo, $user);
        if($result == "errore"){
            echo "errore;no";
        }
        else if(empty($result)){
            echo "404;no";
        }
        else{
            echo "200;".$result[0]["email"];
        }
    }
    else{
        echo "non puoi accedere da qui";
    }