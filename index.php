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

include_once 'index.phtml';