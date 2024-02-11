<?php
    if(!isset($_SESSION)){
        session_start();
    }

    include("classi/CDatabase.php");

    
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        
        //controllare se l'utente è registrato nel db
        $user = $_POST["username"];
        $psw = md5($_POST["password"]);


        //mi collego al db e cerco l'utente
        $classeDB = new CDatabase();
        $classeDB->connessione();

        $query = "SELECT * FROM utente WHERE username = ? AND password = ?";
        $tipo = "ss";
        $row = $classeDB->seleziona($query, $tipo, $user, $psw);

        if($row != "errore"){
            if($row["codiceRegistrazione"] != "0"){
                echo "301"; //l'utente è nel db ma non ha attivato il suo account dalla mail
            }
            else{
                $_SESSION["username"] = $user;

                if($row["amministratore"] == 1){
                    $_SESSION["admin"] = true;
                    echo "admin";
                    exit();
                }
                else if($row["2FA"] == 0){
                    echo "201"; //ritorna se non ha il 2fa attivato
                    exit();
                }
                echo "200"; //ritorna se ha il 2fa attivato
            }
        }
        else{
            //utente non trovato
            echo "404";
        }

        $classeDB->chiudiConnessione();
    }
    else{
        echo "401";
    }