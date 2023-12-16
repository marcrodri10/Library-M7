<?php
    namespace App;

    final class Request{
        private string $controller;
        private string $action;
        private string $method;
        private string $param;
        private bool $api;

        protected $arrURI;

        function __construct()
        {   
            $this->setMethod($_SERVER['REQUEST_METHOD']);      
            $url=$_SERVER['REQUEST_URI'];
            $this->arrURI=extract_path_elements($url);
            $this->setApi(false);
            if( $this->arrURI[0]==""){
                $this->setController('index');
                $this->setAction('index');   
            }
            elseif($this->arrURI[0]=="api"){
                $this->setApi(true);
                $this->arrURI=array_slice( $this->arrURI,1);
                
                $this->extractURI();
            }else{
                $this->arrURI=array_slice( $this->arrURI,0);
                $this->extractURI();
            }
                 
        }
        private function extractURI(){
            //estudi de casos possibles?
            //var_dump($this->arrURI);
            //die;
            $length=count($this->arrURI);
           
            switch($length){
                case 1://only controller
                   
                    if($this->arrURI[0]==""){
                        $this->setController('index');
                    }else{
                        $this->setController($this->arrURI[0]);
                    }
                    $this->setAction('index');
                    break;
                case 2://controller  & action
                    
                    $this->setController($this->arrURI[0]);
                    $this->setAction($this->arrURI[1]);
                    
                    if($this->method == "POST"){
                        $this->setParam(implode('/',$_POST));
                    }
                    
                    break;
                default: //controller & action & params
               
                    $this->setController($this->arrURI[0]);
                    $this->setAction($this->arrURI[1]);
                    $this->setParam($this->arrURI[2]);
                    break;
            }
        }

       
        public function getController()
        {
                return $this->controller;
        }

        public function setController($controller)
        {
                $this->controller = $controller;
                return $this;
        }
       
        public function getAction()
        {
                return $this->action;
        }

        public function setAction($action)
        {
                $this->action = $action;

                return $this;
        }

        public function getMethod()
        {
                return $this->method;
        }

        public function setMethod($method)
        {
                $this->method = $method;
                return $this;
        }

        public function getParam()
        {
                return $this->param;
        }

        public function setParam($param)
        {

                $this->param = $param;
                return $this;
        }
  
        public function setApi($value)
        {
                $this->api = $value;
                return $this;
        }
        public function getApi(){
            return $this->api;
        }

        
    }