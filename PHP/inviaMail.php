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

        //cerca nel db la mail dell'utente
        $query = "SELECT email FROM utente WHERE username = '$user'";
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


        $operazione = $_POST["operazione"];

        //attiva l'account dell'utente
        if($operazione == "attivazione"){
            //codice per generare il codice della registrazione per l'utente
            //per genereare il codice, fare hash di, esempio, id+username+email e aggiungere qualche carattere in più
            //sistemare anche il campo nel db per metterlo a lunghezza fissa
        }
        else if($operazione == "recupera_psw"){
            //recupera password dell'utente
        }



        //questo codice va tolto e sistemato, perché come è adesso non serve
        //toglierlo da qui e sistemarlo per fare l'attivazione e, in futuro, la recupera psw
        $username = $config["email"]["username"];
        $password = $config["email"]["password"];

        $mittente = $config["email"]["mittente"];

        $oggetto = "Benvenuto";
        $contenuto = "benvenuto nel sito. Per completare l'iscrizione devi attivare il tuo account da questo link: " . $link;


        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP(); // enable SMTP

        //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = $config["email"]["host"];
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

