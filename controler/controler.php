<?php
/*
 * Author : Christopher Pardo
 * Date : 24.01.2020
 * Project : Rent a snow
 */

require_once 'model/model.php';

//------------------------------ Return to the page in the view ----------------------

function home()
{
    $news = getAllNews();
    require_once 'view/home.php';
}

function displaySnows()
{
    $snowTypes = getAllSnowTypes();
    require_once 'view/displaySnows.php';
}

function login()
{
    require_once 'view/login.php';
}

function articlePage($article, $rents)
{
    require_once 'view/articlePage.php';
}

function modelPage($model)
{
    $model = getAModel($model);
    require_once 'view/modelPage.php';
}

function inscription()
{
    require_once 'view/inscription.php';
}

function personalPage()
{
    $user = getAnUser($_SESSION["email"]);
    require_once 'view/personalPage.php';
}

function cartPage($cart)
{
    $price = 0;
    if (is_array($cart)) {
        foreach ($cart as $article) {
            $price += $article["price"];
        }
    }
    require_once 'view/cartPage.php';
}

//Disconnect and return the the disconnection's page
function disconnect()
{
    session_unset();
    require_once 'view/disconnection.php';
}

function tryLogin($email, $password)
{
    $users = getUsers(); //Puts the values of the data sheet users in a table

    foreach ($users as $user) {
        //If the username and the password are true the user connect to the session
        if ($user["email"] == $email && password_verify($password, $user["password"])) {
            $_SESSION["firstname"] = $user["firstname"];
            $_SESSION["lastname"] = $user["lastname"];
            $_SESSION["password"] = $user["password"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["id"] = $user["id"];
            $_SESSION["type"] = $user["type"];
            $_SESSION["cart"];

            home(); //Return to de page home
        }
    }

    //If the form is false the page show a error
    if (!isset($_SESSION["firstname"])) {
        $_SESSION["flashmessage"] = "L'e-amil ou le mot de passe est incorrect";
        login();
    }
}

//Covert the value "on" to "true"
function valueForm($value)
{
    if ($value == "on") {
        return 2;
    } else {
        return 1;
    }
}

//Function to register a user
function tryInscription($firstname, $lastname, $password, $email, $phonenumber, $type, $truePassword)
{
    $users = getUsers(); //Puts the values of the data sheet users in a table

    foreach ($users as $user) {
        //Check if the user is unique and show a error if not
        if ($user["email"] == $email) {
            $_SESSION["flashmessage"] = "L'e-mail est déjà utilisé";
            $inscription = false;
            inscription(); //Return to the page of inscription
        }
    }

    //If the username is unique the user is register in the data and log to the session
    if (!isset($inscription)) {
        $type = valueForm($type); //Converts the value


        $newUser = ["firstname" => $firstname,
            "lastname" => $lastname,
            "password" => $password,
            "email" => $email,
            "phonenumber" => $phonenumber,
            "type" => $type];
        addAUser($newUser); //Add the user in the data sheet
        tryLogin($firstname, $lastname, $truePassword); //Log the user
    }
}

function prepareNew($title, $text)
{
    $date = date("Y-m-j G:i:s", time());

    $new = ["title" => $title,
        "text" => $text,
        "date" => $date,
        "user_id" => $_SESSION["id"]];

    addNew($new);
    home();

}

function addToCart($article)
{
    foreach ($_SESSION["cart"] as $cartArticle) {
        if ($cartArticle["id"] == $article["id"]) {
            $_SESSION["flashmessage"] = "Cet article est déjà dans votre panier";
            return modelPage($article["model"]);
        }
    }
    $_SESSION["cart"][] = $article;
    modelPage($article["model"]);
}

function delToCart($articleId)
{
    foreach ($_SESSION["cart"] as $key => $article) {
        if ($article["id"] == $articleId) {
            unset($_SESSION["cart"][$key]);
        }
    }
    cartPage($_SESSION["cart"]);
}

function order($nb_day)
{
    $rent_id = addARent();
    foreach ($_SESSION["cart"] as $article) {
        if ($article["available"] == 1) {
            changeDispo($article["id"]);
            addRentDetail($article["id"], $rent_id, $nb_day);
        } else {
            $_SESSION["flashmessage"] = "Un des article est déjà loué";
            cartPage($_SESSION["cart"]);
        }
    }
    unset($_SESSION["cart"]);
    cartPage('');
}

function getAvailable($available)
{
    switch ($available) {
        case 0 :
            return "Indisponible";
        case 1 :
            return "Disponible";
        default :
            return null;
    }
}

function getSate($state)
{
    switch ($state) {
        case 1 :
            return "Neuf";
        case 2 :
            return "Peut-usé";
        case 3 :
            return "Abîmé";
        case 4 :
            return "Inutilisable";
        default :
            return null;
    }
}

?>