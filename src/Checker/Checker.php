<?php 


namespace App\Checker;

class Checker {

    public static function checkString(string $string){
        if(strlen(trim($string)) != 0){
            return 1;
        }
        else return 0;
    }
}