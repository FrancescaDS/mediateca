<?php
require_once 'functions/functions.php';
require 'includes/database.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>DIRECTOR LIST - MEDIATECA</title>
        <link href="style.css" rel="stylesheet" />
    </head>
    <body>
        
    <?php include "includes/header.php"; ?>
   
    <H1>DIRECTOR LIST</H1>
<?php
    try {
        $sql = 'SELECT * FROM Directors ORDER BY Surname, Name';
        $stmt = $db->prepare($sql);
        $result = $stmt->execute();
        $rows = $stmt->fetchAll();
        echo "<H3>Our DB conteins " . count($rows) . " directors.</H3>";
        echo "<table><tr><td><b>Directors</b></td><td>&nbsp;</td></tr>";

        foreach($rows as $row){
            echo "<tr>";
            echo "<td><A href='director_scheda.php?id=" . $row['IDDirector'] . "'>" . $row['Surname'] ." ". $row['Name'] . "</a></td>";
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