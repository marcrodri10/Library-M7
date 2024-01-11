<?php

    namespace App;

    class FormHandler{
        function __construct()
        {

        }
        function callMethod(){
            $data = $this->getFormData();
            return $data;
        }
        private function getFormData(){
            return $_POST;
        }
    }