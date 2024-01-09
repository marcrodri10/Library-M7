<?php
include_once 'partials/header.tpl.php';
?>
<body>
    <?php  
        $file = fopen('public/markdown/book_'.$book_id.'.md', 'rb');
        if($file){
            while(($line = fgets($file)) !== false){
                if (trim($line) !== '') {
                    if(trim($line[0]) == '#') echo '<h1>'.substr($line, 1).'</h1>';
                    else echo '<p>'.trim($line).'</p>';
                }
                
            }
        }
        
    ?>
</body>

</html>
