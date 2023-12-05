<?php

    namespace App;

    class Session{
        protected $id;
        function __construct()
        {
            session_start();
            $this->id=session_id();
        }
    }