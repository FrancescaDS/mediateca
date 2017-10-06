<?php
require_once 'functions/functions.php';
require 'includes/database.php';
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title>FILM LIST - MEDIATECA</title>
        <link href="style.css" rel="stylesheet" />
    </head>
    <body>

    <?php include "includes/header.php"; ?>
   
    <H1>FILM LIST</H1>
<?php
    try{
        $sql = 'SELECT * FROM Film ORDER BY Year, Title';
        $stmt = $db->prepare($sql);
        $result = $stmt->execute();
        $rows = $stmt->fetchAll();
        echo "<H3>Our DB conteins " . count($rows) . " films.</H3>";
        echo "<table><tr><td><b>Year</b></td>"
            . "<td><b>Title</b></td>"
            . "<td><b>Director</b></td></tr>";

        foreach($rows as $row){
            $Film = new Film($db, $row['IDFilm']);
            $Director = $Film->Director;
            echo "<tr>";
            echo "<td>".$row['Year']."</td>";
            echo "<td><A href='film_scheda.php?id=" . $row['IDFilm'] . "'>" . $row['Title'] . "</a></td>";
            echo "<td>". $Director->getData()['Name'] . " " . $Director->getData()['Surname'] ."</td>";
            echo "<tr>";
        }

        echo "</table>";
        
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }

?>
    
<?php include "includes/liste.php"; ?>
    
<?php include "includes/footer.php"; ?>
  </BODY>
</HTML>
