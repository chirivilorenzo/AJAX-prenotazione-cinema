<?php

    include("classi/CDatabase.php");

    function visualizza(){

        //visualizza la prima parte dell'html
        $stringa = "<table>";
        $stringa .= "<tr>";
        $stringa .= "<th>Locandina</th>";
        $stringa .= "<th>Titolo</th>";
        $stringa .= "<th>Genere</th>";
        $stringa .= "<th>Durata (minuti)</th>";
        $stringa .= "</tr>";
        $stringa .= "<tr>";



        //prendo l'id del film
        $idFilm = $_GET["id"];

        $classeDB = new CDatabase();
        $classeDB->connessione();

        $query = "SELECT film.*, genere.nome AS nome_genere
                    FROM film
                    JOIN `film-genere` ON film.ID = `film-genere`.idFilm
                    JOIN genere ON `film-genere`.idGenere = genere.ID
                    WHERE film.ID = ?";
        $tipo = "i";
        $result = $classeDB->seleziona($query, $tipo, $idFilm);

        if($result != "errore"){
            $generi = [];

            foreach($result as $elemento){
                $titolo = $elemento["titolo"];
                $durata = $elemento["durata"];
                $img = $elemento["locandina"];

                $generi[] = $elemento["nome_genere"];
            }

            $gen = implode(", ", $generi);

            $stringa .= "<td><img src='../IMAGES/$img'/></td>";
            $stringa .= "<td>" . $titolo . "</td>";
            $stringa .= "<td>" . $gen . "</td>";
            $stringa .= "<td>" . $durata . "</td></tr></table>";
            echo $stringa;
        }
        else{
            echo "errore";
        }
    }

    function nonVisualizza(){
        echo "<p>Non si può accedere a questa pagina in questo modo</p>";
    }

    if($_SERVER["REQUEST_METHOD"] === "GET"){
        visualizza();
    }
    else{
        nonVisualizza();
    }


?>
<html>
    <head>
        <link rel="stylesheet" href="../CSS/style_schedaFilm.css">
        <script>
            function indietro(){
                window.history.back();
            }
        </script>
    </head>
    <body>
        <button onclick="indietro()">Indietro</button>
    </body>
</html>