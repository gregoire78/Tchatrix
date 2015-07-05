<?php
//
// Created by Grégoire JONCOUR on 03/07/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//
use App\Facebook\FacebookConnect;

require 'vendor/autoload.php';
session_start(); // Le SDK nécessite l'utilisation de la session
$connect = new FacebookConnect('1610526429223159', 'ab0fc4f736cc5ab4d7e8d5eb041b9d59');
$user = $connect->connect('http://tchatrix.fr/index.php');
if(is_string($user)){
    echo "<a href='$user'>Se connecter avec Facebook</a>";
}else{
    echo "SELECT * FROM users WHERE facebook_id = {$user->getId()} OR email = {$user->getEmail()}";
    var_dump($user->getName(),$user->getEmail(),$user->getLink());
    echo '<a href="logout.php">Disconnect</a>';
}
