<?php
session_start();
header("Content-Type:text/html; charset=UTF-8");

//load class
spl_autoload_register(function ($class) {
    include '../class/' . $class . '.class.php';
});

require_once("../class/view/AView.php");
require_once("../lib/functions.php");

if(function_exists("runDefaultFuncs")){
    runDefaultFuncs();
}

//set language (ru, en)
setLang();

//check post request for translates
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    checkToken();
    if(isset($_POST["lang_en"]))
    {
        changeLang("en");
    }
    if(isset($_POST["lang_ru"]))
    {
        changeLang("ru");
    }
}

//check get params
if(isset($_GET["option"])) {
    $class = trim(strip_tags($_GET["option"]));
} else {
    if(isAuth() || checkCookie()){
        $class = "Profile";
    }else{
        $class = "Login";
    }
}

//if option value matches the class name, this class will be loaded
if(file_exists("../class/view/".$class.".php"))
{
    require_once("../class/view/".$class.".php");
    if(class_exists($class)) {
        $obj = new $class;
        $obj->displayBody();
    }
    else {
        exit("Invalid entry data");
    }
} else {
    exit("Invalid address");
}