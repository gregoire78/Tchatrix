<?php
//
// Created by Grégoire JONCOUR on 03/07/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//

namespace App\Facebook;


use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;

class FacebookConnect {
    private $appId;
    private $appSecret;

    /**
     * @param $appId Facebook Application Id
     * @param $appSecret Facebook Application Secret
     */
    function __construct($appId, $appSecret){

        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    /**
     * @param $redirect_url
     * @return string | Facebook\GraphUser Login URL or GraphUser
     */
    function connect($redirect_url){
        FacebookSession::setDefaultApplication($this->appId, $this->appSecret);
        $helper = new FacebookRedirectLoginHelper($redirect_url);

        if(isset($_SESSION) && isset($_SESSION['fb_token'])){
            $session = new FacebookSession($_SESSION['fb_token']);
        }else{
            $session = $helper->getSessionFromRedirect();
        }

        if($session){
            try{
                $_SESSION['fb_token'] = $session->getToken();
                $request = new FacebookRequest($session, 'GET', '/me');
                $profile = $request->execute()->getGraphObject('Facebook\GraphUser');
                if($profile->getEmail() === null){
                    throw new \Exception('L\'email n\'est disponible');
                }
                return $profile;
            }catch (\Exception $e){
                unset($_SESSION['fb_token']);
                return $helper->getReRequestUrl(['email']);
            }

        }else{
            return $helper->getLoginUrl(['email']);
        }
    }
}
/*
FacebookSession::setDefaultApplication($appId,$appSecret);

$helper = new FacebookRedirectLoginHelper('http://local.dev/fbconnect/index.php');

if(isset($_SESSION) && isset($_SESSION['fb_token']))
{
    $session = new FacebookSession($_SESSION['fb_token']);
}else{
    $session = $helper->getSessionFromRedirect();
}

if($session){
    try{
        $_SESSION['fb_token'] = $session->getToken();
        $request = new FacebookRequest($session,'GET','/me');
        $profile = $request->execute()->getGraphObject('Facebook\GraphUser');
        if($profile->getEmail() === null){
            throw new Exception('Vous n\'avez pas accepter de donner votre email');
        }
        //
        $facebook_id = $profile->getId();
        // SELECT * FROM users WHERE facebook_id = $facebook_id OR email = profile-> getEmail();
        //
        // INSERT INTO users SET facebook_id = $facebook_id, firstname = $profile->getFirstName() ;

    }catch (Exception $e){
        $_SESSION = null;
        session_destroy();
        header('Location: index.php');
    }

}else{
    echo '<a href="' . $helper->getReRequestUrl(['email']) .'">Se connecter avec facebook</a>';
}

*/