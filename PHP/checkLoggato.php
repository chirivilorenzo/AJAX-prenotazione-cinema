<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_SESSION["username"])){
        if(isset($_SESSION["admin"])){
            echo "admin";   //l'utente è un admin
        }
        else{
            echo "200"; //l'utente è un utente normale
        }
    }
    else{
        echo "300"; //l'utente non si è loggato
        exit();
    }