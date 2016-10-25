<?php

//main view class

abstract class AView{

    //every child class has to display its own content
    abstract function displayContent();

    //display header
    protected function displayHeader()
    {
      include "parts/header-layout.php";
    }

    //display footer
    protected function displayFooter()
    {
        include "parts/footer-layout.php";
    }

    //display page
    public function displayBody()
    {
        $this->displayHeader();
        $this->displayContent();
        $this->displayFooter();
    }
    
    
}