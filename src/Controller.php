<?php
    namespace App;
    use App\Request;
    use App\Session;

    abstract class Controller{
        protected Session $session;
        protected Request $request;

        public function __construct($session,$request){
            $this->session=$session;
            $this->request=$request;
        }
    }