<?php
/*
 * Author : Christopher Pardo
 * Date : 22.01.2020
 * Project : Rent a snow
 */

session_start();
require "controler/controler.php";


if (isset($_POST["username"])){
    //extract($_POST); //$username,$password,$birthdate,$employe,$wantnews,$date-inscription
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
}

$page = $_POST["action"];
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
        tryLogin($username, $password);
        break;
    case "articlePage" :
        articlePage();
        break;
    case "inscription" :
        inscription();
        break;
    case "tryInscription" :
        $birthdate = $_POST["birthdate"];
        $employe = $_POST["employe"];
        $wantnews = $_POST["wantnews"];
        tryInscription($username, $password, $birthdate, $employe, $wantnews);
        break;
    case "personalPage" :
        personalPage();
        break;
    default :
        home();
        break;
}

?>
