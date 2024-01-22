<?php

namespace App;

class Session{
    protected $id;

    // Constructor to start the session and set the session ID
    function __construct()
    {
        session_start();
        $this->id = session_id();
    }

    // Set session value
    static function setSession($session, $value, $sessionName = null)
    {
        if ($sessionName) {
            // If sessionName is provided, set the specific session property
            $_SESSION[$session]->$sessionName = $value;
        } else {
            // Otherwise, set the entire session
            $_SESSION[$session] = $value;
        }
    }

    // Get session value
    static function getSession($session)
    {
        return $_SESSION[$session];
    }

    // Delete session
    static function deleteSession($session)
    {
        unset($_SESSION[$session]);
    }

    // Check if session exists
    static function checkSession($session)
    {
        return isset($_SESSION[$session]);
    }

    // Destroy all sessions
    static function destroySessions()
    {
        session_unset();
        session_destroy();
    }
}
