<?php

//registration page

class Registration extends AView{

    public function displayContent()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["reg"]))
        {
            checkToken();
            new Validate("Registration", $_POST);
        }
        $this->showRegForm();
    }

    //display login form
    private function showRegForm()
    {
        include "parts/regist-layout.php";
    }
    
}