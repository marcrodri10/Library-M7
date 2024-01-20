<?php
include_once 'partials/header.tpl.php';
?>
<body>
<?php include_once 'partials/nav.tpl.php'; ?>
    <div class="container-book">

    <?php  
        $file = fopen('public/markdown/book_'.$book_id.'.md', 'rb');
        if ($file) {
            while (($line = fgets($file)) !== false) {
                if (trim($line) !== '') {
                    if ($line[0] == '#') {
                        echo '<h1>' . trim(substr($line, 1)) . '</h1>';
                    } else {
                        echo '<p>' . trim($line) . '</p>';
                    }
                }
            }
            fclose($file);
        }
    ?>

    </div>
</body>

</html>
