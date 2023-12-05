<?php 
   
   function extract_path_elements($request_uri) {
        $elements = explode('/', trim($request_uri, '/'));
    return $elements;
}

/*
function dd(){
    foreach(func_get_args() as $arg){
        echo "<pre>"
        .print_r($arg).
        "</pre>";
    }
    die;
}
*/