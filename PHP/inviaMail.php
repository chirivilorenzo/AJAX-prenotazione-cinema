<?php
    require('../PHPMailer/src/PHPMailer.php');
    require("../PHPMailer/src/SMTP.php");
    require("../PHPMailer/src/Exception.php");

    function inviaMail($username, $password, $mittente, $destinatario, $host, $oggetto, $contenuto){
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP(); // enable SMTP

        //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = $host;
        $mail->Port = 465; // or 587

        $mail->IsHTML(true);
        $mail->Username = $username;
        $mail->Password = $password;

        $mail->SetFrom($mittente);
        $mail->Subject = $oggetto;
        $mail->Body = $contenuto;
        $mail->AddAddress($destinatario);

        if($mail->Send()) {
            return true;
        }
        else {
            return false;
        }
    }

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $config = parse_ini_file("../CONFIGURAZIONE/config.ini", true);

        //cose per il db
        $servername = $config["database"]["servername"];
        $usernamedb = $config["database"]["username"];
        $passworddb = $config["database"]["password"];
        $dbname = $config["database"]["dbname"];

        //cose per la mail
        $username = $config["email"]["username"];
        $password = $config["email"]["password"];
        $mittente = $config["email"]["mittente"];
        $host = $config["email"]["host"];

        $destinatario = $_POST["indirizzo"];

        //mi collego al db
        $mysqli = new mysqli($servername, $usernamedb, $passworddb, $dbname);
        $mysqli->set_charset("utf8mb4");

        $operazione = $_POST["operazione"];
        if($operazione == "attivazione"){
            //codice per generare il codice della registrazione per l'utente
            //per genereare il codice, fare hash di, esempio, id+username+email
            //sistemare anche il campo nel db per metterlo a lunghezza fissa

            //mi collego al db e prendo id, username ed email dell'utente
            $query = "SELECT ID, username, email FROM utente WHERE email = '$destinatario'";
            $result = $mysqli->query($query);
            $row = $result->fetch_assoc();

            $nomeUtente = $row["username"];

            if($result->num_rows > 0){
                $flag = 0;

                //genera l'hash
                $hash = md5($row["ID"] . $row["username"] . $row["email"]);

                //ora salvo l'hash dentro al campo dell'utente interessato
                $query = "UPDATE utente SET codiceRegistrazione = '$hash' WHERE email = '$destinatario'";
                $result = $mysqli->query($query);

                if($result){
                  $flag = 1;
                }

                if($flag == 1){
                    //prepara il link da inviare
                    $link = "<a href='http://localhost/chirivi/AJAX-prenotazione-cinema/PHP/attivazioneAccount.php?id=$hash&user=$nomeUtente'>Clicca qui</a>";
                    $oggetto = "Benvenuto";
                    $contenuto = "benvenuto nel sito. Per completare l'iscrizione devi attivare il tuo account da questo link: " . $link;

                    //invia la mail
                    if(inviaMail($username, $password, $mittente, $destinatario, $host, $oggetto, $contenuto)){
                        echo "200";
                        exit();
                    }
                }
                else{
                    echo "301";
                    exit();
                }
            }
        }
        else if($operazione == "recupera_psw"){
            //recupera password dell'utente
        }








        //questo codice va tolto e sistemato, perché come è adesso non serve
        //toglierlo da qui e sistemarlo per fare l'attivazione e, in futuro, la recupera psw






    }
