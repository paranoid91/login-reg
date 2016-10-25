<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Registration & Login Form" />
    <meta name="keywords" content="Registration, Login" />
    <meta name="author" content="Leri Bobokhidze" />
    <!-- google fonts -->
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/main.css" />
    <title><?=clearStr($GLOBALS["trans"]["title"])?></title>
    <link rel="icon" type="image/png" href="img/favicon.ico" />
</head>
<body>
<div id="wrapper">
    <div class="content-main">
        <div class="header-slogan">
            <h1><?=clearStr($GLOBALS["trans"]["welcome"])?></h1>
        </div>
        <div class="flags">
            <form class="lang-form" action="<?php $_SERVER["PHP_SELF"];?>" enctype="application/x-www-form-urlencoded" method="POST" accept-charset="UTF-8">
                <input type="hidden" value="<?=clearStr($_SESSION["token"])?>" name="token"/>
                <a class="lang-link" href="javascript:void(0);" title="english">
                    <input type="submit" class="en-sub" name="lang_en" value=""/>
                </a>
            </form>
            <form class="lang-form" action="<?php $_SERVER["PHP_SELF"];?>" enctype="application/x-www-form-urlencoded" method="POST" accept-charset="UTF-8">
                <input type="hidden" value="<?=clearStr($_SESSION["token"])?>" name="token"/>
                <a class="lang-link" href="javascript:void(0);" title="русский язык">
                    <input type="submit" class="ru-sub" name="lang_ru" value=""/>
                </a>
            </form>
        </div>