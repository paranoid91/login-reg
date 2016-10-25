<?php

//redirect
function redirect($path)
{
    header("Location: index.php?option=" . $path);
    exit;
}

//check if token is valid
function checkToken()
{
    if(!isset($_POST["token"]) || $_POST["token"] != $_SESSION["token"])
    {
        redirect("Login");
    }
    return true;
}

//save error message in session
function saveErrorMsg($errors)
{
    if(!empty($errors))
    {
        $_SESSION["err"] = $errors;
    }
}

// filtering input data, covert to string
function clearStr($string)
{
    $string = htmlentities($string, ENT_QUOTES, "UTF-8");
    $string = (string)trim($string);
    return $string;
}

// filtering input data, covert to integer
function clearInt($int)
{
    return (int) strip_tags( trim($int) );
}

//create md5 hash
function doubleHash($string)
{
    return md5(md5($string));
}

//check if user is authorized
function isAuth()
{
    if(isset($_SESSION["user_id"]) and isset($_SESSION["code"]))
        return true;
    return false;
}

//logout
function logout()
{
    session_destroy();
    setcookie("user",'',1);
    setcookie("code",'',1);
    redirect("Login");
}

//check if isset cookies for auto login
function checkCookie()
{
   if(isset($_COOKIE['user']) and isset($_COOKIE['code']))
    {
        $user_id = clearInt($_COOKIE['user']);
        $code = clearStr($_COOKIE['code']);
        $db = DB::getInstance();
        $ses_data = $db->getSessionInfo($user_id);
        
        if($ses_data)
        {
            if($code === $ses_data["code_sess"])
            {
                $_SESSION["user_id"] = $ses_data["user_id"];
                $_SESSION["code"] = $code;
                return true;
            }
        }

        return false;
    }

    return false;
}

//translates
function setLang()
{
    if(!isset($_SESSION["lang"]))
    {
        $_SESSION["lang"] = "en";
        include "trans/en_trans.php";
    }
    else
    {
        include "trans/{$_SESSION["lang"]}_trans.php";
    }
}

function changeLang($lang)
{
    //get current query string
    $query_str = (string)strip_tags(trim($_SERVER["QUERY_STRING"]));

    if($lang == "en")
    {
        $_SESSION["lang"] = "en";
    }
    elseif($lang == "ru")
    {
        $_SESSION["lang"] = "ru";
    }

    header("refresh:0;url=?{$query_str}");
    exit;
}

//put value in form field after redirect
function putValue($value)
{
    if(isset($_SESSION) && isset($_SESSION[$value]) && strlen($_SESSION[$value]) > 0)
        return $_SESSION[$value];
    return "";
}

//remove fields value from session
function removeValue($value)
{
    if(isset($_SESSION) && isset($_SESSION[$value]) && strlen($_SESSION[$value]) > 0)
      unset($_SESSION[$value]);
}

//generate random string
function randStr($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++)
    {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

//create token
function createToken()
{
	if(!isset($_SESSION["token"]))
	{
		$_SESSION["token"] = randStr(40);
	}
}

//destroy error messages from session
function destroyMsg($key)
{
    if(isset($_SESSION[$key]))
    {
        unset($_SESSION[$key]);
    }
}

//add success message to session
function addSuccessMsg($msg)
{
    $_SESSION["success"] = $msg;
}

//view result of expression
function viewResult($data)
{
    echo "<pre>"; 
    var_dump($data); 
    echo "</pre>";
    exit;
}

//run necessary functions
function runDefaultFuncs()
{
    ini_set('session.use_only_cookies', true);
    ini_set("display_errors", 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    createToken();
}
