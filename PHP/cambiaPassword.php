<?php

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $nuovaPsw = md5($_POST["password"]);
        $user = $_POST["username"];

        $classeDB = new CDatabase();
        $classeDB->connessione();

        //metto la nuova password all'utente
        $query = "UPDATE utente SET password = ? WHERE username = ?";
        $tipo = "ss";
        if($classeDB->aggiorna($query, $tipo, $nuovaPsw, $user)){

            //metto il codiceResetPsw dell'utente a 0
            $query = "UPDATE utente SET codiceResetPsw = '0' WHERE username = ?";
            $tipo = "s";
            if($classeDB->aggiorna($query, $tipo, $user)){
                echo "200";
            }
            else{
                echo "300";
            }
        }
    }