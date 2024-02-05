<?php
    //si occupa sia di attivare la 2fa per quell'utente
    //sia per fare la login ogni volta con la 2fa
    if(!isset($_SESSION)){
        session_start();
    }

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $config = parse_ini_file("../CONFIGURAZIONE/config.ini", true);

        $servername = $config["database"]["servername"];
        $username = $config["database"]["username"];
        $password = $config["database"]["password"];
        $dbname = $config["database"]["dbname"];

        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $mysqli->set_charset('utf8mb4');


        $operazione = $_POST["operazione"];
        $user = $_POST["username"];

        //abilita la 2fa per quell'utente
        if($operazione == "abilita"){

            //controlla se l'utente si trova nel db
            $query = "SELECT COUNT(*) AS utentiTot FROM utente WHERE username = '$user'";
            $result = $mysqli->query($query);
            $row = $result->fetch_assoc();
            $tot = $row["utentiTot"];

            //se entra, vuol dire che l'utente si trova nel db
            if($tot > 0){
                $query = "UPDATE utente SET 2FA = 1 WHERE username = '$user'";
                $result = $mysqli->query($query);

                if($result){
                    echo "200";
                }
                else{
                    echo "300";
                }
            }
            else{
                echo "404";
            }
        }

        //controlla il 2fa per l'utente
        else if($operazione == "controlla"){

        }
    }

