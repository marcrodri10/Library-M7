<?php
// Import necessary classes
use App\Session;

// Include the header template
include_once 'partials/header.tpl.php';
?>

<body>
    <?php
    // Include the navigation template
    include_once 'partials/nav.tpl.php';
    ?>
    <div class="container-fluid b-flex-center-center-col history">
        <h1>User Book History</h1>
        <?php
        // Check if the user role is 'reader' and display relevant information
        if (Session::getSession('user_data')->getRole() == 'reader') {
            if (Session::getSession('user_data')->getReadedBooks() != 0) {
                echo '<h2>You have read a total of ' . Session::getSession('user_data')->getReadedBooks() . ' books</h2>';
            } else {
                echo '<h2>You have not started any book yet.</h2>';
            }
        }

        // Check if there are books in the user's history and display a table
        if (sizeof($userHistoryBooks) > 0) {
            echo '<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Book</th>
                        </tr>
                    </thead>
                    <tbody>';
            $i = 1;
            foreach ($userHistoryBooks as $book) {
                echo "<tr>
                        <td>$i</td>
                        <td>$book->title</td>
                      </tr>";
                $i++;
            }
            echo '</tbody>
                </table>';
        }
        ?>
    </div>
</body>

</html>