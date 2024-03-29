<?php

    include("classi/CDatabase.php");

    if($_SERVER["REQUEST_METHOD"] === "GET"){

        $classeDB = new CDatabase();
        $classeDB->connessione();

        //prendo l'hash dall'url
        $hash = $_GET["id"];

        //prendo l'username dall'url
        $user = $_GET["user"];

        //query per controllare che l'utente con quel nome abbia quell'hash nel db
        $query = "SELECT COUNT(*) FROM utente WHERE username = ? AND codiceRegistrazione = ?";
        $tipo = "ss";

        //ritorna 1 se trova il record, 0 se non lo trova
        $variabile = $classeDB->cercaSingoloRecord($query, $tipo, $user, $hash);

        //se utente trovato, abilita l'account
        if($variabile != "0"){
            $query = "UPDATE utente SET codiceRegistrazione = '0' WHERE username = ?";
            $tipo = "s";

            //aggiorna il codiceRegistrazione dell'utente
            if($classeDB->aggiorna($query, $tipo, $user)){
                echo "Account attivato";
            }
            else{
                echo "Errore, account non attivato";
            }
        }
        else{
            echo "questo utente ha già attivato l'account";
        }

        $classeDB->chiudiConnessione();
    }