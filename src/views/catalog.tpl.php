<?php

use App\Session;
use App\Model\Book;
use App\Model\File;
include_once 'partials/header.tpl.php';

if(Session::getSession('user_subscription') == false || Session::getSession('user_subscription')->getIsActive() == 0) include_once 'partials/modalSubscription.tpl.php';
else {
    include_once 'partials/membershipRemember.tpl.php';
}
?>

<body>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>Library Catalog</h1>
        <nav>
            <a href="/userProfile">Edit Account</a>
            <a href="/subscriptions">Subscriptions</a>
            <a href="/history">History</a>
        </nav>
        <form action="/catalog" method="post">
        <div class="search mb-5">
            <input type="text" name="search" id="search" value="<?php 
            if(Session::checkSession('search')) echo Session::getSession('search');
            ?>">
            <?php if(Session::checkSession('search')) { ?>
                <a href="/catalog">RESET</a>
           <?php } ?>
        </div>
        </form>
        
        <div class='d-flex flex-wrap gap-5 align-items-center'>
        <?php 
            foreach($books as $book => $b){
                $bookClass = new Book($b->book_id, $b->title, $b->author, $b->genre, $b->price);
                $fileClass = new File($files[$book]->file_id, $files[$book]->book_id, $files[$book]->route);
                echo '<div>';
                echo "<img src='/public/images/book_" . $bookClass->getBookId() . ".jpg'>";
                echo "  <p><strong>Title:</strong> ".$bookClass->getTitle()."</p>
                        <p><strong>Author:</strong> ".$bookClass->getAuthor()."</p>                      
                        <p><strong>Genre:</strong> ".$bookClass->getGenre()."</p>
                        <p><strong>Price:</strong> ".$bookClass->getPrice()."€</p>";
                        
                        if(file_exists("public/markdown/book_".$bookClass->getBookId().".md")){
                            if(Session::getSession('user_subscription') !== false && Session::getSession('user_subscription')->getIsActive() == 1){
                                echo "<a class='btn btn-primary' href='/book/read/". $bookClass->getBookId() ."'>Read</a>";
                            }
                            else echo "<a href='/catalog' class='btn btn-primary'>Read</a>";
                            
                        }
                        
                echo "</div>";
            }
        ?>

        </div>
        
        
    </div>
    
</body>


</html>