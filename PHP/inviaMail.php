<?php

    include("classi/CMail.php");
    include("classi/CDatabase.php");

    $nomeUtente = "";
    $destinatario = "";

    function generaHash($classeDB){
        global $nomeUtente;
        global $destinatario;

        $query = "SELECT ID, username, email FROM utente WHERE email = ?";
        $tipo = "s";
        $elemento = $classeDB->seleziona($query, $tipo, $destinatario);
        
        if($elemento == "errore"){
            return "errore";
        }
        else{
            $nomeUtente = $elemento[0]["username"];

            //genera l'hash
            $hash = md5($elemento[0]["ID"] . $elemento[0]["username"] . $elemento[0]["email"]);

            return $hash;
        }
    }

    function salvaHash($classeDB, $query, $tipo, $hash){
        global $destinatario;

        if($classeDB->aggiorna($query, $tipo, $hash, $destinatario)){
            return true;
        }
        else{
            return false;
        }
    }

    function preparaInviaMail($oggetto, $contenuto, $mail){
        global $destinatario;

        $mail->ottieniInfo($destinatario, $oggetto, $contenuto);
        if($mail->inviaMail()){
            echo "200"; //email inviata
            exit();
        }
        else{
            echo "300"; //email non inviata
            exit();
        }
    }


    if($_SERVER["REQUEST_METHOD"] === "POST"){
        global $destinatario;
        global $nomeUtente;

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

            $hash = generaHash($classeDB);
            if($hash != "errore"){

                //ora salvo l'hash dentro al campo dell'utente interessato
                $query = "UPDATE utente SET codiceRegistrazione = ? WHERE email = ?";
                $tipo = "ss";
                
                if(salvaHash($classeDB, $query, $tipo, $hash)){

                    $classeDB->chiudiConnessione();

                    //prepara il link da inviare
                    $link = "<a href='http://localhost/chirivi/AJAX-prenotazione-cinema/PHP/attivazioneAccount.php?id=$hash&user=$nomeUtente'>Clicca qui</a>";
                    $oggetto = "Benvenuto";
                    $contenuto = "benvenuto nel sito. Per completare l'iscrizione devi attivare il tuo account da questo link: " . $link;

                    preparaInviaMail($oggetto, $contenuto, $mail);   
                }
                else{
                    echo "301"; //errore nell'aggiornare il codiceRegistrazione di quell'utente
                    exit();
                }
            }
        }
        else if($operazione == "recupera_psw"){
            //recupera password dell'utente
            $hash = generaHash($classeDB);

            if($hash != "errore"){

                //ora salvo l'hash dentro al campo dell'utente interessato
                $query = "UPDATE utente SET codiceResetPsw = ? WHERE email = ?";
                $tipo = "ss";
                
                if(salvaHash($classeDB, $query, $tipo, $hash)){

                    $classeDB->chiudiConnessione();

                    //prepara il link da inviare
                    $link = "<a href='http://localhost/chirivi/AJAX-prenotazione-cinema/PHP/resetPassword.php?id=$hash&user=$nomeUtente'>Clicca qui</a>";
                    $oggetto = "Reset password";
                    $contenuto = "ripristina la password tramite questo link: " . $link;

                    preparaInviaMail($oggetto, $contenuto, $mail);   
                }
                else{
                    echo "301"; //errore nell'aggiornare il codiceResetPsw di quell'utente
                    exit();
                }
            }
        }
    }
