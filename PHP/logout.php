<?php

    if(!isset($_SESSION)){
        session_start();
    }

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $data = $_POST["info"];

        if($data == "logout"){
            session_unset();
            session_destroy();
            echo "200";
            exit();
        }
        else{
            echo "301";
        }
    }