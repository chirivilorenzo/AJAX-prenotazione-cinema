<?php
    if(!isset($_SESSION)){
        session_start();
    }

    
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        
        //controllare se l'utente è registrato nel db
        $user = $_POST["username"];
        $psw = md5($_POST["password"]);


        //mi collego al db e cerco l'utente
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "prenotazionecinema";


        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $mysqli->set_charset('utf8mb4');

        $result = $mysqli->query("SELECT * FROM utente WHERE username = '$user' AND password = '$psw'");

        if(($row = $result->fetch_assoc()) != null){
            //utente autenticato

            $_SESSION["username"] = $user;

            if($row["amministratore"] == 1){
                $_SESSION["admin"] = true;
                echo "admin";
                exit();
            }

            echo "200";
        }
        else{
            //utente non trovato
            echo "404";
        }
    }
    else{
        echo "401";
    }