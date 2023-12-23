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
            
            if(Session::getSession('user_suscription') === false || Session::getSession('user_suscription')['is_active'] == 0){
                $currentDate = new DateTime();

                if($_POST['suscription'] == 'trial'){
                
                    $fields = [
                        'user_id' => Session::getSession('user_data')['user_id'],
                        'start_date' => $currentDate->format('Y-m-d'),
                        'finish_date' => $currentDate->add(new DateInterval('P1M'))->format('Y-m-d'),
                        'is_active' => 1
                    ];
    
                }
                else if($_POST['suscription'] == 'year'){
                
                    $fields = [
                        'user_id' => Session::getSession('user_data')['user_id'],
                        'start_date' => $currentDate->format('Y-m-d'),
                        'finish_date' => $currentDate->add(new DateInterval('P1Y'))->format('Y-m-d'),
                        'is_active' => 1
                    ];
                    
                }

                Registry::get('database')->insert('Suscriptions', $fields);

                $userSuscription = Registry::get('database')
                    ->selectAll('Suscriptions')
                    ->condition('user_id', 'Suscriptions', Session::getSession('user_data')['user_id'], '=')
                    ->get();
            
                Session::setSession('user_suscription', $userSuscription[0]);
                
            
            }

            header('Location:/suscriptions');

        }
       
    }