<?php
    session_start();
    session_unset();
    echo 'Logging out please wait';
    session_destroy();
    
    header('location: /forum/index.php?out=true');

?>