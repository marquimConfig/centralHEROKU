<?php session_start() ?>
<html lang="pt-br" itemscope itemtype="https://schema.org/WebSite"> 
<head>
    <title>Central MegaLink</title>
    <meta name="description" content="Nova Central de pagementos Megalink">
    <meta name="robots" content="index, no-follow">
    
    <meta itemprop="Name" content="Central Megalink">
    <meta itemprop="description" content="Nova Central de pagementos Megalink">
    
</head>
<body>
    <?php 
        if(!isset($_SESSION['login'])){
            include_once('https://central-mega.herokuapp.com/login.php');
        }else{
            include_once('https://central-mega.herokuapp.com/home.php');
        }
    ?>

</body>

</html>