<?php
    require_once "backend/Handler.php";
    @session_start();
    function report(){
        $handler = new Handler();
        $handler->report();
    }
    
    $title = "Nakuru Online";

?>