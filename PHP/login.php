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
                $.get
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