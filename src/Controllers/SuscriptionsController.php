<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
    use App\Controller;
    use App\View;
    use App\Registry;
    use DateTime;
    use DateInterval;
    class SuscriptionsController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function index(){
            echo View::render('suscriptions');
        }

        function edit(){
            
            if(Session::getSession('user_suscription') === false){
                $currentDate = new DateTime();

                if($_POST['suscription'] == 'trial'){
                
                    $fields = [
                        'user_id' => Session::getSession('user_data')['user_id'],
                        'start_date' => $currentDate->format('Y-m-d'),
                        'finish_date' => $currentDate->add(new DateInterval('P1M'))->format('Y-m-d'),
                        'is_active' => 1,
                        'type' => 'trial',
                    ];
    
                }
                else if($_POST['suscription'] == 'year'){
                
                    $fields = [
                        'user_id' => Session::getSession('user_data')['user_id'],
                        'start_date' => $currentDate->format('Y-m-d'),
                        'finish_date' => $currentDate->add(new DateInterval('P1Y'))->format('Y-m-d'),
                        'is_active' => 1,
                        'type' => 'year',
                    ];
                    
                }

                Registry::get('database')->insert('Suscriptions', $fields);

                
                
            
            }
            else if(Session::getSession('user_suscription') !== false){
                
                if(Session::getSession('user_suscription')['is_active'] == 0){
                    $currentDate = new DateTime();

                    $fields = [
                        'user_id' => Session::getSession('user_data')['user_id'],
                        'start_date' => $currentDate->format('Y-m-d'),
                        'finish_date' => $currentDate->add(new DateInterval('P1Y'))->format('Y-m-d'),
                        'is_active' => 1,
                        'type' => 'year',
                    ];

                    Registry::get('database')
                        ->update('suscriptions', $fields)
                        ->condition('user_id', 'suscriptions', Session::getSession('user_data')['user_id'], '=')
                        ->get();
                    
                }
                else {
                    if($_POST['suscription'] == 'cancel'){
                        Registry::get('database')
                            ->update('suscriptions', ['is_active' => 0])
                            ->condition('user_id', 'suscriptions', Session::getSession('user_data')['user_id'], '=')
                            ->get();
                    
                        Session::setSession('user_suscription', 0, 'is_active');
                    }
                    
                }
            }
            $userSuscription = Registry::get('database')
                ->selectAll('Suscriptions')
                ->condition('user_id', 'Suscriptions', Session::getSession('user_data')['user_id'], '=')
                ->get();
            
            Session::setSession('user_suscription', $userSuscription[0]);

            header('Location:/suscriptions');

        }
        function prueba(){
            if($_POST['suscription'] != 'cancel'){
                $this->showPayment();
            }
            else $this->cancel();
        }
        function showPayment(){
            $_COOKIE['suscription'] = $_POST['suscription'];
            include_once 'src/views/payment.tpl.php';
        }

        function cancel(){
            if($_POST['suscription'] == 'cancel'){
                Registry::get('database')
                    ->update('suscriptions', ['is_active' => 0])
                    ->condition('user_id', 'suscriptions', Session::getSession('user_data')['user_id'], '=')
                    ->get();
            
                Session::setSession('user_suscription', 0, 'is_active');
            }
            header('Location:/suscriptions');
        }
        function payment(){
            
            $type = explode('-', $_POST['payment']);
            if($type[0] == 'pay'){
                
                if(Session::getSession('user_suscription') === false){
                    $currentDate = new DateTime();
    
                    if($type[1] == 'trial'){
                    
                        $fields = [
                            'user_id' => Session::getSession('user_data')['user_id'],
                            'start_date' => $currentDate->format('Y-m-d'),
                            'finish_date' => $currentDate->add(new DateInterval('P1M'))->format('Y-m-d'),
                            'is_active' => 1,
                            'type' => 'trial',
                        ];
        
                    }
                    else if($type[1] == 'year'){
                    
                        $fields = [
                            'user_id' => Session::getSession('user_data')['user_id'],
                            'start_date' => $currentDate->format('Y-m-d'),
                            'finish_date' => $currentDate->add(new DateInterval('P1Y'))->format('Y-m-d'),
                            'is_active' => 1,
                            'type' => 'year',
                        ];
                        
                    }
    
                    Registry::get('database')->insert('Suscriptions', $fields);
                    
                    
                }

                else if(Session::getSession('user_suscription') !== false){
                    
                    if(Session::getSession('user_suscription')['is_active'] == 0){
                        $currentDate = new DateTime();
    
                        $fields = [
                            'user_id' => Session::getSession('user_data')['user_id'],
                            'start_date' => $currentDate->format('Y-m-d'),
                            'finish_date' => $currentDate->add(new DateInterval('P1Y'))->format('Y-m-d'),
                            'is_active' => 1,
                            'type' => 'year',
                        ];
    
                        Registry::get('database')
                            ->update('suscriptions', $fields)
                            ->condition('user_id', 'suscriptions', Session::getSession('user_data')['user_id'], '=')
                            ->get();
                        
                    }

                }
                $userSuscription = Registry::get('database')
                    ->selectAll('Suscriptions')
                    ->condition('user_id', 'Suscriptions', Session::getSession('user_data')['user_id'], '=')
                    ->get();

                $paymentFields = [
                    'user_id' => Session::getSession('user_data')['user_id'],
                    'amount' => $type[2],
                    'date' => $currentDate->format('Y-m-d'),
                ];
                Registry::get('database')
                    ->insert('payments', $paymentFields); 
                
                Session::setSession('user_suscription', $userSuscription[0]);
    
                
            }
            header('Location:/suscriptions');
        }
       
    }