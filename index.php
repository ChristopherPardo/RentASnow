<?php
session_start();
require "controler/controler.php";

$page = $_GET["action"];
switch ($page){
    case "displaySnows" :
        displaySnows();
        break;
    case "login" :
        login();
        break;
    case "disconnect" :
        disconnect();
        break;
    case "tryLogin" :
        $username = $_POST["username"];
        $password = $_POST["password"];
        tryLogin($username, $password);
        break;
    case "articlePage" :
        articlePage();
        break;
    case "inscription" :
        inscription();
        break;
    case "tryInscription" :
        $username = $_POST["username"];
        $password = $_POST["password"];
        $birthdate = $_POST["birthdate"];
        $employe = $_POST["employe"];
        $wantnews = $_POST["wantnews"];
        tryInscription($username, $password, $birthdate, $employe, $wantnews);
        break;
    default :
        home();
        break;
}

?>
