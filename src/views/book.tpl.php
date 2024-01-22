<?php

// Include the header template
include_once 'partials/header.tpl.php';

?>

<body>

    <?php
    // Include the navigation template
    include_once 'partials/nav.tpl.php';
    ?>

    <div class="container-book">

        <?php
        // Open the markdown file for reading
        $file = fopen('public/markdown/book_' . $book_id . '.md', 'rb');
        
        // Check if the file is opened successfully
        if ($file) {
            // Read the file line by line
            while (($line = fgets($file)) !== false) {
                // Check if the line is not empty
                if (trim($line) !== '') {
                    // Check if the line starts with '#' indicating a heading
                    if ($line[0] == '#') {
                        echo '<h1>' . trim(substr($line, 1)) . '</h1>';
                    } else {
                        echo '<p>' . trim($line) . '</p>';
                    }
                }
            }
            
            // Close the file after reading
            fclose($file);
        }
        ?>

    </div>

</body>

</html>
