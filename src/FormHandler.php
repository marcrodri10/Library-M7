<?php

    namespace App;

    class FormHandler{
        private array $post;
        function __construct(array $post)
        {
            $this->post = $post;
        }

        function getPostData(){
            return $this->post;
        }
    }