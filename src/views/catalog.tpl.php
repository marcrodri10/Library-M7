<?php
include_once 'partials/header.tpl.php';

?>

<body>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>Library Catalog</h1>
        <nav>
            <a href="/updateUserProfile/">Edit Account</a>
        </nav>
        <div class='d-flex flex-wrap gap-5 align-items-center'>
        <?php 
            foreach($books as $book){
                echo '<div>';
                echo "<img src="."'"."/public/images/book_".$book['book_id'].".jpg'" .">";
                echo "  <p><strong>Title:</strong> ".$book['title']."</p>
                        <p><strong>Author:</strong> ".$book['author']."</p>                      
                        <p><strong>Genre:</strong> ".$book['genre']."</p>
                        <p><strong>Price:</strong>".$book['price']."€</p>";
                echo "</div>";
            }
        ?>
        </div>
    </div>
    
</body>

</html>