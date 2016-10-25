<?php

//profile page

class Profile extends AView{


    public function __construct()
    {
        //check if user is authenticated 
        if(!isAuth()){
            redirect("Login");
        }

        //logout
        if(isset($_POST["logout"])){
            logout();
        }
    }

    public function displayContent()
    {
        $user = $this->getUserData();
        include "parts/profile-layout.php";
    }

    private function getUserData()
    {
        $id = clearInt($_SESSION["user_id"]);
        $db = DB::getInstance();
        $user = $db->getUser($id, false);
        return $user;
    }
    
}
