<?php
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
                    url: "cambiaPassword.php",
                    data: {password: dato, username: nome},
                    success: function(response){
                        if(response == "200"){
                            window.location.href = "../HTML/login.html";
                        }
                        else{
                            alert("errore, password non cambiata");
                        }
                    }
                });
            }
        </script>
    </head>
    <body>
    </body>
</html>