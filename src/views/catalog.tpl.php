<?php

use App\Session;
use App\Model\Book;
use App\Model\File;

include_once 'partials/header.tpl.php';

if (Session::getSession('user_subscription') == false || Session::getSession('user_subscription')->getIsActive() == 0) include_once 'partials/modalSubscription.tpl.php';
else {
    include_once 'partials/membershipRemember.tpl.php';
}
?>

<body>
    <div class="main-container">
        <?php include_once 'partials/nav.tpl.php'; ?>
        <form action="/catalog/formHandler" method="post" id="search-form" class="b-flex-center-center-row">
            <div class="search">
            <svg class="icon-search" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
                <input type="text" name="search" id="search" class="form-control input" placeholder="Search" value="<?php echo Session::checkSession('search') ? Session::getSession('search') : ''; ?>">
                <?php if (Session::checkSession('search')) { ?>
                    <button type="submit" class="btn btn-light">RESET</button>
                <?php } ?>
            </div>
        </form>

        <div class="books-container">
            <?php
            foreach ($books as $book => $b) {
                $bookClass = new Book($b->book_id, $b->title, $b->author, $b->genre, $b->price);
                $fileClass = new File($files[$book]->file_id, $files[$book]->book_id, $files[$book]->route);
                echo '<div class="book b-flex-center-center-col">';
                echo "<img src='/public/images/book_" . $bookClass->getBookId() . ".jpg' class='img-fluid'>";
                echo "  <p><strong>Title:</strong> " . $bookClass->getTitle() . "</p>
                        <p><strong>Author:</strong> " . $bookClass->getAuthor() . "</p>                      
                        <p><strong>Genre:</strong> " . $bookClass->getGenre() . "</p>
                        <p><strong>Price:</strong> " . $bookClass->getPrice() . "€</p>";

                if (file_exists("public/markdown/book_" . $bookClass->getBookId() . ".md")) {
                    if (Session::getSession('user_subscription') !== false && Session::getSession('user_subscription')->getIsActive() == 1) {
                        echo  "<a class='btn btn-primary btn-read' href='/book/read/" . $bookClass->getBookId() . "'>Read</a>";
                    } else {
                        echo '<a class="cssbuttons-io-button" href="/catalog/formHandler">
                        Read
                        <div class="icon">
                            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                            </svg>
                        </div>
                    </a>';
                    }
                }

                echo "</div>";
            }
            ?>

        </div>
    </div>

</body>


</html>