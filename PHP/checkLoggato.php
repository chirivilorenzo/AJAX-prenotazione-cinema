<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_SESSION["username"])){
        if(isset($_SESSION["admin"])){
            echo "admin";
        }
        else{
            echo "200";
        }
    }
    else{
        echo "300";
        exit();
    }