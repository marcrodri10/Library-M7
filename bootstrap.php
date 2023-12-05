<?php

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();

    use App\Database\QueryBuilder;
    use App\Database\Connection;
    use App\Registry;
    // register all the services
    

    Registry::bind('config', require 'config.php');
    
    Registry::bind('database', new QueryBuilder(
        Connection::make(Registry::get('config'))
    ));
    