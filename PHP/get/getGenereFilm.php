<?php

    header('Content-Type: application/json');
    include("../classi/CDatabase.php");

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $genere = $_POST["genere"];

        $classeDB = new CDatabase();
        $classeDB->connessione();
    
        $query = "SELECT film.*
                    FROM film
                    JOIN `film-genere` ON film.ID = `film-genere`.idFilm
                    JOIN genere ON `film-genere`.idGenere = genere.ID
                    WHERE genere.nome = ?";
        $tipo = "s";
        $result = $classeDB->seleziona($query, $tipo, $genere);
    
        if($result != "errore"){
    
            $film = array();
            foreach($result as $elemento){
                $film[] = $elemento;
            }
            
            echo json_encode($film);
        }
        else{
            echo "301";
        }
    }