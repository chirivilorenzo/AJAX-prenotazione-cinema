<?php
    require('../PHPMailer/src/PHPMailer.php');
    require("../PHPMailer/src/SMTP.php");
    require("../PHPMailer/src/Exception.php");

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $config = parse_ini_file("../CONFIGURAZIONE/config.ini", true);

        $servername = $config["database"]["servername"];
        $username = $config["database"]["username"];
        $password = $config["database"]["password"];
        $dbname = $config["database"]["dbname"];

        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $mysqli->set_charset("utf8mb4");

        $user = $_POST["username"];
        $destinatario = "";

        $query = "SELECT email from utente WHERE username = '$user'";
        $result = $mysqli->query($query);

        if($result === false){
            echo "errore nella query" . $mysqli->error;
            exit();
        }

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $destinatario = $row["email"];
        }
        else{
            echo "404";
            exit();
        }



        $username = $config["email"]["username"];
        $password = $config["email"]["password"];

        $mittente = $config["email"]["mittente"];

        $oggetto = "Benvenuto";
        $contenuto = "ti sei registrato correttamente";


        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP(); // enable SMTP

        //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587

        $mail->IsHTML(true);
        $mail->Username = $username;
        $mail->Password = $password;

        $mail->SetFrom($mittente);
        $mail->Subject = $oggetto;
        $mail->Body = $contenuto;
        $mail->AddAddress($destinatario);

        if($mail->Send()) {
            echo "200";
        }
        else {
            echo "301";
        }
    }

