<?php

    require('../PHPMailer/src/PHPMailer.php');
    require("../PHPMailer/src/SMTP.php");
    require("../PHPMailer/src/Exception.php");

    class CMail{
        public $username;
        public $password;
        public $mittente;
        public $destinatario;
        public $host;
        public $oggetto;
        public $contenuto;

        public function __construct(){
            $this->username = "xxxxxxxxxxxxxxxx";
            $this->password = "xxxxxxxxxxxxxxxx";
            $this->mittente = "xxxxxxxxxxxxxxxx";
            $this->host = "smtp.gmail.com";
        }

        public function ottieniInfo($destinatario, $oggetto, $contenuto){
            $this->destinatario = $destinatario;
            $this->oggetto = $oggetto;
            $this->contenuto = $contenuto;
        }

        public function inviaMail(){
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->IsSMTP(); // enable SMTP
    
            //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host = $this->host;
            $mail->Port = 465; // or 587
    
            $mail->IsHTML(true);
            $mail->Username = $this->username;
            $mail->Password = $this->password;
    
            $mail->SetFrom($this->mittente);
            $mail->Subject = $this->oggetto;
            $mail->Body = $this->contenuto;
            $mail->AddAddress($this->destinatario);
    
            if($mail->Send()) {
                return true;
            }
            else {
                return false;
            }
        }
    }