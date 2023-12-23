<?php

    namespace App;

    class Cookie{
        function __construct()
        {

        }

        static function setCookie($cookie, $value, $time = 0){
            setcookie($cookie, $value, $time, '/');
        }
        static function getCookie($cookie){
            return $_COOKIE[$cookie];
        }
        static function deleteCookie($cookie){
            setcookie($cookie, '', time() - 3600, '/');
        }
    }