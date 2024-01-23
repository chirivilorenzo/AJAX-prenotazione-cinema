<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script>
            $("document").ready(function(){
                $("login").click(function(){
                    verificaUtente();
                });
            });

            function verificaUtente(){
                $.get("getUtenti.php", {}, function(data){
                    
                    let user = $("#username").val();
                    let psw = $("#password").val();

                    for(let i = 0; i < data.length; i++){
                        if(data[i]["username"] == user && data[i]["password"] == psw){
                            $.ajax({
                                url: "elencoFilm.php",
                                type: "POST",
                                data: { username: user},
                                success: function(response){
                                    window.location.href = "elencoFilm.php";
                                }
                            });
                            return;
                        }
                    }

                    $("#risultato").text = "login errato, riprova";
                });
            }
        </script>
    </head>
    <body>
        username: <input id="username" type="text"><br>
        password: <input id="password" type="password"><br>
        <button id="login">Login</button><br>
        <p id="risultato"></p>
    </body>
</html>