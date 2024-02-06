<?php
    if(!isset($_SESSION)){
        session_start();
    }

    
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        
        //controllare se l'utente è registrato nel db
        $user = $_POST["username"];
        $psw = md5($_POST["password"]);


        //mi collego al db e cerco l'utente
        $config = parse_ini_file("../CONFIGURAZIONE/config.ini", true);

        $servername = $config["database"]["servername"];
        $username = $config["database"]["username"];
        $password = $config["database"]["password"];
        $dbname = $config["database"]["dbname"];


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
            else if($row["2FA"] == 0){
                echo "201"; //ritorna se non ha il 2fa attivato
                exit();
            }
            echo "200"; //ritorna se ha il 2fa attivato
        }
        else{
            //utente non trovato
            echo "404";
        }
    }
    else{
        echo "401";
    }