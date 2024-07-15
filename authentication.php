<?php
@session_start();

function authenticateTenant(){
    authenticateLoggedIn();
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $url = urlencode($url);
    if(!isset($_SESSION['type']) || $_SESSION['type'] != "tenant"){
        header("Location: login.php?redirectTo=$url");
        die;   
    }
}

function authenticateAdmin(){
    authenticateLoggedIn();
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $url = urlencode($url);
    if(!isset($_SESSION['type']) || $_SESSION['type'] != "ADMIN"){
        header("Location: login.php?redirectTo=$url");
        die;   
    }
}

function authenticateLoggedIn(){
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $url = urlencode($url);
    if(!isset($_SESSION['id'])){
        header("Location: login.php?redirectTo=$url");
        die;   
    }
}

?>