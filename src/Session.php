<?php

    namespace App;

    class Session{
        protected $id;
        function __construct()
        {
            session_start();
            $this->id=session_id();
        }

        static function setSession($session, $value, $sessionName = null){
            if($sessionName){
                
                $_SESSION[$session]->$sessionName = $value;
            }
            else {
                $_SESSION[$session] = $value;
            }
        }
        static function getSession($session){
            return $_SESSION[$session];
        }
        static function deleteSession($session){
            unset($_SESSION[$session]);
        }

        static function checkSession($session){
            return isset($_SESSION[$session]);
        }
        static function destroySessions(){
            session_unset();
            session_destroy();
        }
    }