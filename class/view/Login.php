<?php

//login page

class Login extends AView{

    public function __construct()
    {
        if(($_SERVER["REQUEST_METHOD"] == "POST") and (isset($_POST["login"])))
        {
            checkToken();
            new Validate("Login", $_POST);
        }
    }

    public function displayContent()
    {
        $this->showLoginForm();
    }

    //display login form
    private function showLoginForm()
    {
        include "parts/login-layout.php";
    }
}