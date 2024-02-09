<?php

    class CDatabase{
        public $servername;
        public $username;
        public $password;
        public $dbname;
        public $mysqli;
        public $query;

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

        public function inserisci($query, $tipoParametri, ...$parametri){
            $this->query = $query;
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param($tipoParametri, $parametri);

            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public function seleziona(){

        }

        public function elimina(){

        }

        public function aggiorna(){

        }
    }