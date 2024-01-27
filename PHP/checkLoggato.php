<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_SESSION["username"])){
        if($_POST["info"] == "check"){
            echo "200";
            exit();
        }
        else{
            echo "username si ma altro no";
            exit();
        }
    }
    else{
        echo "300";
        exit();
    }