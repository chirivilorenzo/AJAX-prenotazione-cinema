<?php

    class CDatabase{
        public $servername;
        public $username;
        public $password;
        public $dbname;
        public $mysqli;

        public function __construct(){
            $this->servername = "localhost";
            $this->username = "root";
            $this->password = "";
            $this->dbname = "prenotazionecinema";
        }

        public function connessione(){
            $this->mysqli = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            $this->mysqli->set_charset('utf8mb4');
        }

        public function getLastID(){
            return $this->mysqli->insert_id;
        }

        public function inserisci($query, $tipoParametri, ...$parametri){
            $stmt = $this->mysqli->prepare($query);

            $stmt->bind_param($tipoParametri, ...$parametri);

            if($stmt->execute()){
                $stmt->close();
                return true;
            }
            else{
                $stmt->close();
                return false;
            }
        }

        public function seleziona($query, $tipoParametri, $nomeColonna, ...$parametri){
            $stmt = $this->mysqli->prepare($query);

            $stmt->bind_param($tipoParametri, ...$parametri);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if($row !== false){
                $stmt->close();
                return $row[$nomeColonna];
            }
            else{
                return "errore";
            }
        }

        public function elimina($query, $tipoParametri, ...$parametri){
            $stmt = $this->mysqli->prepare($query);

            $stmt->bind_param($tipoParametri, ...$parametri);

            if($stmt->execute()){
                $stmt->close();
                return true;
            }
            else{
                $stmt->close();
                return false;
            }
        }

        public function aggiorna(){

        }

        public function chiudiConnessione(){
            $this->mysqli->close();
        }
    }