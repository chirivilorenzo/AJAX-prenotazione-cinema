<?php

    if($_SERVER["REQUEST_METHOD"] === "GET"){

        $config = parse_ini_file("../CONFIGURAZIONE/config.ini", true);

        //cose per il db
        $servername = $config["database"]["servername"];
        $usernamedb = $config["database"]["username"];
        $passworddb = $config["database"]["password"];
        $dbname = $config["database"]["dbname"];

        //prendo l'hash dall'url
        $hash = $_GET["id"];

        //prendo l'username dall'url
        $user = $_GET["user"];


        //mi collego al db
        $mysqli = new mysqli($servername, $usernamedb, $passworddb, $dbname);
        $mysqli->set_charset("utf8mb4");

        //cambio nel db il codiceRegistrazione a 0
        $query = "UPDATE utente SET codiceRegistrazione = '0' WHERE username = '$user'";
        $result = $mysqli->query($query);

        if($result){
            echo "Account attivato";
        }
        else{
            echo "Errore, account non attivato";
        }
    }