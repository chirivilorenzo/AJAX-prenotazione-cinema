<?php
    if(!isset($_SESSION)){
        session_start();
    }

    include("classi/CDatabase.php");

    
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        
        //prendo le info in post
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
                    echo "admin";   //l'utente è un admin
                    exit();
                }
                else if($row["2FA"] == 0){
                    echo "201"; //l'utente non ha il 2fa attivo
                    exit();
                }
                echo "200"; //l'utente ha il 2fa
            }
        }
        else{
            echo "404"; //utente non trovato
        }

        $classeDB->chiudiConnessione();
    }
    else{
        echo "401"; //se si prova ad accedere alla pagina da browser
    }