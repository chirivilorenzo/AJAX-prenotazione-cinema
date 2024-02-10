<?php

    include("classi/CDatabase.php");

    if(!isset($_SESSION)){
        session_start();
    }


    if($_SERVER["REQUEST_METHOD"] === "POST"){


        $flag = 0;  //serve per capire se il server ha inserito sia il film che i suoi generi
        $lastID = 0;    //id del film inserito nella tabella "film"

        //variabili prese in post
        $titolo = $_POST["titolo"];
        $durata = $_POST["durata"];
        $generi = $_POST["generi"];
        $immagine = $_POST["immagine"];


        //classe del db
        $classeDB = new CDatabase();
        $classeDB->connessione();

        //qui salva il film nella tabella film
        $query = "INSERT INTO film (titolo, durata, locandina) VALUES (?, ?, ?)";
        $tipo = "sss";
        
        if($classeDB->inserisci($query, $tipo, $titolo, $durata, $immagine)){
            $flag = 1;
            $lastID = $classeDB->getLastID();
        }
        else{
            $flag = 0;
        }


        //qui deve salvare il film con i suoi generi nella tabella film-genere
        if($flag != 0 && $lastID != 0){

            //prima devo prendere tutti gli id dei generi che ha selezionato l'admin
            $nuovoArray = array();
            foreach ($generi as $genereNome){
                $query = "SELECT ID FROM genere WHERE nome=?";
                $tipo = "s";
                $elemento = $classeDB->seleziona($query, $tipo, "ID", $genereNome);

                if($elemento == "errore"){
                    echo "errore";
                }
                else{
                    $nuovoArray[] = $elemento;
                }
            }


            foreach($nuovoArray as $genereID){

                $query = "INSERT INTO `film-genere` (idFilm, idGenere) VALUES (?, ?)";
                $tipo = "ii";

                if(!$classeDB->inserisci($query, $tipo, $lastID, $genereID)){
                    $flag = 0;
                    break;
                }
            }
        }

        $classeDB->chiudiConnessione();

        if($flag == 1){
            echo "200";
        }
        else{
            echo "300";
        }
    }