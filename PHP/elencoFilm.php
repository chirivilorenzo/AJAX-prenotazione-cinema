<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION["username"])){
        header("Location: ../HTML/login.html");
    }

    //collegarsi al db per prendere i film
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "prenotazionecinema";


    $mysqli = new mysqli($servername, $username, $password, $dbname);
    $mysqli->set_charset('utf8mb4');

    $result = $mysqli->query("SELECT * FROM film");
?>
<html>
    <head>
        <link rel="stylesheet" href="../CSS/style_elencoFilm.css">
    </head>
    <body>
        <table>
            <?php
                while(($row = $result->fetch_assoc()) != null){
                    echo "<tr>";
                    echo "<td><a href='schedaFilm.php?id=".$row["ID"] . "' target='_blank'>
                    <img src='data:image/png;base64,". base64_encode($row["locandina"]) . "'/>
                    <br>" . $row["titolo"] . "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </body>
</html>