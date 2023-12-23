<?php

use App\Session;

include_once 'partials/header.tpl.php';

if(Session::getSession('user_suscription') == false || Session::getSession('user_suscription')['is_active'] == 0) include_once 'partials/modalSuscription.tpl.php';
?>

<body>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>Library Catalog</h1>
        <nav>
            <a href="/updateUserProfile">Edit Account</a>
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
            foreach($books as $book){
                echo '<div>';
                echo "<img src="."'"."/public/images/book_".$book['book_id'].".jpg'" .">";
                echo "  <p><strong>Title:</strong> ".$book['title']."</p>
                        <p><strong>Author:</strong> ".$book['author']."</p>                      
                        <p><strong>Genre:</strong> ".$book['genre']."</p>
                        <p><strong>Price:</strong> ".$book['price']."€</p>
                        <a href='/catalog/suscriptionAlert'>Read</a>";
                echo "</div>";
            }
        ?>
        </div>
        
        
    </div>
    
</body>

</html>