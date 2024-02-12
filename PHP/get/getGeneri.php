<?php

    header('Content-Type: application/json');
    include("../classi/CDatabase.php");

    
    if($_SERVER["REQUEST_METHOD"] === "GET"){
        
        $classeDB = new CDatabase();
        $classeDB->connessione();

        $query = "SELECT * FROM genere";
        $result = $classeDB->seleziona($query, "",);

        $generi = [];
        foreach($result as $elemento){
            $generi[] = $elemento;
        }

        echo json_encode($generi);
    }
    else{
        echo "401";
    }