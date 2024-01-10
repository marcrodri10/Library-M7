<?php
include_once 'partials/header.tpl.php';
?>
<body>
    <div class="container-fluid">
        <h1>User Book History</h1>
        <?php
        
          if(sizeof($userHistoryBooks) > 0){
            echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Book</th>
              </tr>
            </thead>
            <tbody>';
            foreach($userHistoryBooks as $book){
              echo "<tr><td>$book->title</td></tr>";
            }
              
          }
        ?>
        </tbody>
        </table>
    </div>
</body>

</html>
