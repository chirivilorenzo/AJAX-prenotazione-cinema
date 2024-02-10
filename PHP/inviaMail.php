<?php

    include("classi/CMail.php");
    include("classi/CDatabase.php");


    if($_SERVER["REQUEST_METHOD"] === "POST"){

        //cose per la mail
        $mail = new CMail();
        $destinatario = $_POST["indirizzo"];    

        //mi collego al db
        $classeDB = new CDatabase();
        $classeDB->connessione();

        
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

                    $mail->ottieniInfo($destinatario, $oggetto, $contenuto);

                    //invia la mail
                    if($mail->inviaMail()){
                        echo "200";
                    }
                    else{
                        echo "300";
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
