<?php

    //prendo l'id del film
    $idFilm = $_GET["id"];

    //cerco nel db il film con quell'id e visualizzo tutte le sue info
    $config = parse_ini_file("../CONFIGURAZIONE/config.ini", true);

    $servername = $config["database"]["servername"];
    $username = $config["database"]["username"];
    $password = $config["database"]["password"];
    $dbname = $config["database"]["dbname"];


    $mysqli = new mysqli($servername, $username, $password, $dbname);
    $mysqli->set_charset('utf8mb4');

    $query = "SELECT film.*, genere.nome AS nome_genere
                FROM film
                JOIN `film-genere` ON film.ID = `film-genere`.idFilm
                JOIN genere ON `film-genere`.idGenere = genere.ID
                WHERE film.ID = '$idFilm'";

    $result = $mysqli->query($query);
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

                if($result){
                    $generi = [];

                    while(($row = $result->fetch_assoc()) != null){
                        $titolo = $row["titolo"];
                        $durata = $row["durata"];
                        $img = $row["locandina"];

                        $generi[] = $row["nome_genere"];
                    }

                    $gen = implode(", ", $generi);

                    echo "<td><img src='../IMAGES/$img'/></td>";
                    echo "<td>" . $titolo . "</td>";
                    echo "<td>" . $gen . "</td>";
                    echo "<td>" . $durata . "</td>";
                }
                else{
                    echo "errore";
                }
            ?>
            </tr>
        </table>
    </body>
</html>