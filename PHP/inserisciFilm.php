<?php
    if(!isset($_SESSION)){
        session_start();
    }


    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $flag = 0;  //serve per capire se il server ha inserito sia il film che i suoi generi
        $lastID = 0;

        $config = parse_ini_file("../CONFIGURAZIONE/config.ini", true);

        $servername = $config["database"]["servername"];
        $username = $config["database"]["username"];
        $password = $config["database"]["password"];
        $dbname = $config["database"]["dbname"];

        
        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $mysqli->set_charset('utf8mb4');

        
        $titolo = $_POST["titolo"];
        $durata = $_POST["durata"];
        $generi = $_POST["generi"];
        $immagine = $_POST["immagine"];


        

        //qui salva il film nella tabella film
        $query = "INSERT INTO film (titolo, durata, locandina) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('sss', $titolo, $durata, $immagine);

        if ($stmt->execute()) {
            $flag = 1;
            $lastID = $mysqli->insert_id;
        }
        else {
            $flag = 0;
        }

        $stmt->close();


        //qui deve salvare il film con i suoi generi nella tabella film-genere
        if($flag != 0 && $lastID != 0){

            //prima devo prendere tutti gli id dei generi che ha selezionato l'admin
            foreach ($generi as $genereNome){
                $query = "SELECT ID FROM genere WHERE nome=?";

                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("s", $genereNome);
                $stmt->execute();

                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                $nuovoArray[] = $row["ID"];

                $stmt->close();
            }




            foreach($nuovoArray as $genereID){

                $query = "INSERT INTO `film-genere` (idFilm, idGenere) VALUES (?, ?)";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("ii", $lastID, $genereID);

                if(!$stmt->execute()){
                    $flag = 0;
                    break;
                }


                $stmt->close();
            }
        }

        $mysqli->close();


        if($flag == 1){
            echo "200";
        }
        else{
            echo "300";
        }

    }