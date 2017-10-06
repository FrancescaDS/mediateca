<?php
try {

    $dsn = 'mysql:host=localhost;dbname=media';
    $db = new PDO($dsn, 'root', '');

} catch (PDOException $e) {

    exit('Failed to connect: ' . $e->getMessage());

}

?>
