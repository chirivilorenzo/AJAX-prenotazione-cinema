<?php

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $config = parse_ini_file("../CONFIGURAZIONE/config.ini", true);

        $servername = $config["database"]["servername"];
        $username = $config["database"]["username"];
        $password = $config["database"]["password"];
        $dbname = $config["database"]["dbname"];
        

        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $mysqli->set_charset('utf8mb4');

        $user = $_POST["username"];
        $psw = md5($_POST["password"]);
        $email = $_POST["email"];


        $query = "INSERT INTO utente (username, password, email) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("sss", $user, $psw, $email);

        if($stmt->execute()){
            echo "200";
        }
        else{
            echo "301";
        }

        $stmt->close();
        $mysqli->close();
    }