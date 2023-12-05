<?php
    namespace App;

   
    use App\Request;
    use App\Session;

    final class App{
        protected Session $session;
        protected Request $request;

        function __construct()
        {
            $this->request=new Request;
            $this->session=new Session;
            //$request nos ofrece api o controlador y accion
            $controller=$this->request->getController();
            $action=$this->request->getAction();  
            $this->dispatch($this->request->getApi(),$controller,$action);
        }
        
        private function dispatch($api,$controller,$action){
          try{
              if(in_array($controller,$this->getRoutes($api))){
                if($api){
                  $nameController='\\App\Api\Controllers\\'.ucfirst($controller).'Controller';
                
                }else{
                  $nameController='\\App\Controllers\\'.ucfirst($controller).'Controller';
                }
                $objContr=new $nameController(
                  $this->session,
                  $this->request);
                if(is_callable([$objContr,$action])){
                    call_user_func([$objContr,$action]);
                }else{
                  throw new \Exception("Action not found");
                }
              }else{
                throw new \Exception("Route not found");
              }    
          }catch(\Exception $e){
            die($e->getMessage());
          }
        }
        private function getRoutes($api):array{
          $routes=[];
          if($api){
            $dir=__DIR__.'/api/Controllers';}
            else{
              $dir=__DIR__.'/Controllers';}
          $handle=opendir($dir);
          while(($entry=readdir($handle))!=false){
            if($entry!='.' && $entry!='..'){
              $routes[]=strtolower(substr($entry,0,-14));
            }
          }
          return $routes;
        }
    }