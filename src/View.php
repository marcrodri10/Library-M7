<?php

    namespace App;

    class View{

        static function render(string $template,array $data=[]):string{
                if($data){
                    extract($data,EXTR_OVERWRITE);
                }
                //inicializar buffer de salida
                ob_start();
                require 'src/views/'.$template.'.tpl.php';
                $rendered=ob_get_clean();
                return (string)$rendered;
        }
    }