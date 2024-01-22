<?php
    namespace App\Controllers;
    use App\Request;
    use App\Session;
    use App\Controller;
    use App\Registry;
    use App\View;

    /**
 * Class BookController
 *
 * This class represents a controller for handling book-related actions.
 * It extends the base Controller class.
 *
 */
    class BookController extends Controller {
      
        function __construct($session,$request)
        {
            parent::__construct($session,$request);
        }        
        
        function read(){
            // Check if user has an active subscription
            if($this->session::getSession('user_subscription') !== false && $this->session::getSession('user_subscription')->getIsActive() != 0){
                
                // Get book ID from request parameters
                $book_id = $this->request->getParam();
        
                // Check user's reading history
                $userHistory = Registry::get('database')
                    ->select('History', ['book_id'])
                    ->condition(['user_id'],'History', [$this->session::getSession('user_data')->getId()], '=')
                    ->get();
                
                // If user has a reading history
                if(sizeof($userHistory) != 0){
                    $array = [];
                    foreach ($userHistory as $item) {
                        $array[] =  $item->book_id;
                    }
                    
                    // If the book is not in the user's history, add it
                    if(!in_array($book_id,$array)){
                        Registry::get('database')
                            ->insert('History', [
                                'user_id' => $this->session::getSession('user_data')->getId(),
                                'book_id' => $book_id]
                            )
                            ->get();
        
                        // Update user's readed books count if they are a reader
                        if(Session::getSession('user_data')->getRole() == 'reader'){
                            $this->session::getSession('user_data')->setReadedBooks($this->session::getSession('user_data')->getReadedBooks() + 1);
                            Registry::get('database')
                                ->update('Readers', ['readed_books' => $this->session::getSession('user_data')->getReadedBooks()])
                                ->condition(['user_id'], 'Readers', [$this->session::getSession('user_data')->getId()], '=')
                                ->get();
                        }
                    }
                }
                // If user has no reading history, add the book to history
                else {
                    Registry::get('database')
                        ->insert('History', [
                            'user_id' => $this->session::getSession('user_data')->getId(),
                            'book_id' => $book_id]
                        )
                        ->get();
                    
                    // Update user's readed books count if they are a reader
                    if(Session::getSession('user_data')->getRole() == 'reader'){
                        $this->session::getSession('user_data')->setReadedBooks($this->session::getSession('user_data')->getReadedBooks() + 1);
                        Registry::get('database')
                            ->update('Readers', ['readed_books' => $this->session::getSession('user_data')->getReadedBooks()])
                            ->condition(['user_id'], 'Readers', [$this->session::getSession('user_data')->getId()], '=')
                            ->get();
                    }
                }
        
                // Render the book view
                echo View::render('book', ['book_id' => $book_id]);
            }
            // Redirect to catalog if user has no active subscription
            else {
                header('Location:/catalog');
            }
        }
        

       
    }