<?php

    //prendo l'id del film
    $idFilm = $_GET["id"];

    //cerco nel db il film con quell'id e visualizzo tutte le sue info
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "prenotazionecinema";


    $mysqli = new mysqli($servername, $username, $password, $dbname);
    $mysqli->set_charset('utf8mb4');

    $result = $mysqli->query("SELECT * FROM film WHERE id='$idFilm'");
?>
<html>
    <head>
        <link rel="stylesheet" href="../CSS/style_schedaFilm.css">
    </head>
    <body>
        <table>
            <tr>
                <th>Locandina</th>
                <th>Titolo</th>
                <th>Genere</th>
                <th>Durata (minuti)</th>
            </tr>
            <tr>
            <?php
                if(($row = $result->fetch_assoc()) != null){
                    //visualizza info film
                    //echo "<tr>";
                    echo "<td><img src='data:image/png;base64,". base64_encode($row["locandina"]) . "'/></td>";
                    //echo "</tr>";

                    //echo "<tr>";
                    echo "<td>" . $row["titolo"] . "</td>";
                    //echo "</tr>";

                    //echo "<tr>";
                    echo "<td>" . $row["genere"] . "</td>";
                    //echo "</tr>";

                    //echo "<tr>";
                    echo "<td>" . $row["durata"] . "</td>";
                    //echo "</tr>";
                }
                else{
                    echo "nessun film trovato con id = " . $idFilm;
                }
            ?>
            </tr>
        </table>
    </body>
</html>