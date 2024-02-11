<?php

    include("classi/CMail.php");
    include("classi/CDatabase.php");


    if($_SERVER["REQUEST_METHOD"] === "POST"){

        //cose per la mail
        $mail = new CMail();
        $destinatario = $_POST["indirizzo"];
        $nomeUtente = "";   

        //mi collego al db
        $classeDB = new CDatabase();
        $classeDB->connessione();

        //l'operazione serve per capire se la pagina deve attivare una account o recuperare una psw
        $operazione = $_POST["operazione"];
        if($operazione == "attivazione"){
            //codice per generare il codice della registrazione per l'utente
            //per genereare il codice, fare hash di id+username+email

            //mi collego al db e prendo id, username ed email dell'utente
            $query = "SELECT ID, username, email FROM utente WHERE email = ?";
            $tipo = "s";
            $elemento = $classeDB->seleziona($query, $tipo, $destinatario);

            if($elemento == "errore"){
                echo "errore";  //errore nella query
                exit();
            }
            else{
                $nomeUtente = $elemento["username"];

                //genera l'hash
                $hash = md5($elemento["ID"] . $elemento["username"] . $elemento["email"]);

                //ora salvo l'hash dentro al campo dell'utente interessato
                $query = "UPDATE utente SET codiceRegistrazione = ? WHERE email = ?";
                $tipo = "ss";
                
                if($classeDB->aggiorna($query, $tipo, $hash, $destinatario)){

                    $classeDB->chiudiConnessione();

                    //prepara il link da inviare
                    $link = "<a href='http://localhost/chirivi/AJAX-prenotazione-cinema/PHP/attivazioneAccount.php?id=$hash&user=$nomeUtente'>Clicca qui</a>";
                    $oggetto = "Benvenuto";
                    $contenuto = "benvenuto nel sito. Per completare l'iscrizione devi attivare il tuo account da questo link: " . $link;

                    $mail->ottieniInfo($destinatario, $oggetto, $contenuto);

                    //invia la mail
                    if($mail->inviaMail()){
                        echo "200"; //email inviata
                    }
                    else{
                        echo "300"; //email non inviata
                    }                    
                }
                else{
                    echo "301"; //errore nell'aggiornare il codiceRegistrazione di quell'utente
                    exit();
                }
            }
        }
        else if($operazione == "recupera_psw"){
            //recupera password dell'utente
        }






    }
