<?php

//sarà la pagina associata al link che invia all'utente per cambiare psw
//chiede la nuova password e la mette nel db
//prima si deve assicurare che l'utente sia effettivamente lui
//lo fa grazie al token che gli viene passato dall'url (hash di nome + id + email)

    include("classi/CDatabase.php");


    if($_SERVER["REQUEST_METHOD"] === "GET"){

        $classeDB = new CDatabase();
        $classeDB->connessione();

        //prendo l'hash dall'url
        $hash = $_GET["id"];

        //prendo l'username dall'url
        $user = $_GET["user"];

        //query per controllare che l'utente con quel nome abbia quell'hash nel db
        $query = "SELECT COUNT(*) FROM utente WHERE username = ? AND codiceResetPsw = ?";
        $tipo = "ss";

        //ritorna 1 se trova il record, 0 se non lo trova
        $variabile = $classeDB->cercaSingoloRecord($query, $tipo, $user, $hash);

        //se utente trovato, reimposta psw
        if($variabile == "1"){
            //genero codice html per reimpostare psw
            echo "<p id='user'>$user</p>
                nuova password: <input type='password' id='input'>
                <button id='btn'>cambia</button>";

        }
        else{
            echo "questo utente non deve reimpostare la psw";
            $classeDB->chiudiConnessione();
        }
    }
    
    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $nuovaPsw = md5($_POST["password"]);
        $user = $_POST["username"];

        $classeDB = new CDatabase();
        $classeDB->connessione();

        //metto la nuova password all'utente
        $query = "UPDATE utente SET password = ? WHERE username = ?";
        $tipo = "ss";
        if($classeDB->aggiorna($query, $tipo, $nuovaPsw, $user)){

            //metto il codiceResetPsw dell'utente a 0
            $query = "UPDATE utente SET codiceResetPsw = '0' WHERE username = ?";
            $tipo = "s";
            if($classeDB->aggiorna($query, $tipo, $user)){
                echo "200"; //non serve a niente perché ritorna l'intera pagina html insieme a questo
            }
        }
    }
?>

<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script>
            $("document").ready(function(){
                $("#btn").click(function(){
                    inviaDati();
                })
            });

            function inviaDati(){
                let dato = $("#input").val();
                let nome = $("#user").text();

                $.ajax({
                    type: "POST",
                    url: "resetPassword.php",
                    data: {password: dato, username: nome},
                    success: function(response){
                        window.location.href = "../HTML/login.html";
                    }
                });
            }
        </script>
    </head>
    <body>
    </body>
</html>