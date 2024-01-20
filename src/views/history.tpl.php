<?php
use App\Session;
include_once 'partials/header.tpl.php';
?>
<body>
  <?php include_once 'partials/nav.tpl.php'; ?>
    <div class="container-fluid  b-flex-center-center-col history">
        <h1>User Book History</h1>
        <?php
          if(Session::getSession('user_data')->getRole() == 'reader'){
            if(Session::getSession('user_data')->getReadedBooks() != 0){
              echo '<h2>You have read a total of '.Session::getSession('user_data')->getReadedBooks().' books</h2>';
            }
            else echo '<h2>You have not started any book yet.</h2>';
          }
          if(sizeof($userHistoryBooks) > 0){
            echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Book</th>
              </tr>
            </thead>
            <tbody>';
            $i = 1;
            foreach($userHistoryBooks as $book){
              echo "<tr>
              <td>$i</td>
              <td>$book->title</td>
              </tr>";
              $i++;
            }
              
          }
          
        ?>
        </tbody>
        </table>
    </div>
</body>

</html>
